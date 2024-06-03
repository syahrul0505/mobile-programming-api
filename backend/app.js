const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Pool } = require('pg');
const util = require('util');
const writeCoil = require('./readModbus.js');
const schedule = require('node-schedule');

const bodyParser = require('body-parser');

// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }));

// parse application/json
app.use(bodyParser.json());

// Enable CORS
app.use((req, res, next) => {
  res.setHeader('Access-Control-Allow-Origin', 'http://management-vmond.test');
  res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
  next();
});

const pool = new Pool({
  host: 'db-vmond-production.ctkm9cxdes8h.ap-southeast-3.rds.amazonaws.com',
  port: 5432,
  database: 'management-vmond',
  user: 'postgres',
  password: 'PassVmondSukses',
});

const promisifiedQuery = util.promisify(pool.query).bind(pool);

// setInterval(() => {
//     BilliardOrder()
//     RealtimeDashboardKitchen()
// }, 1000);

async function RealtimeDashboardKitchen() {
    const query1 = `SELECT * FROM orders 
    WHERE created_at = CURRENT_DATE
    AND status_pesanan = 'process'
    ORDER BY created_at ASC`;

    const [result1] = await Promise.all([promisifiedQuery(query1)]);

    const orderFromSql1 = result1.rows;

    console.log(orderFromSql1);

    // io.emit('notif-order', {
    //     data: data
    // })
}
async function BilliardOrder() {
  try {
    const query1 = `SELECT * FROM orders 
    WHERE time_from IS NOT NULL
    AND time_to IS NOT NULL
    AND date IS NOT NULL
    AND status_lamp = 'OFF'
    AND status_running = 'NOT START'
    AND status_pembayaran = 'Paid'
    AND date = CURRENT_DATE
    ORDER BY date ASC, time_from ASC, time_to ASC
    LIMIT 1`;

    const query2 = `SELECT * FROM orders 
    WHERE time_from IS NOT NULL
    AND time_to IS NOT NULL 
    AND date IS NOT NULL 
    AND status_lamp = 'ON' 
    AND (status_running = 'START' OR status_running = 'ALMOST') 
    AND status_pembayaran = 'Paid' 
    AND date = CURRENT_DATE
    ORDER BY date ASC, time_from ASC, time_to ASC
    LIMIT 1`;

    const [result1, result2] = await Promise.all([promisifiedQuery(query1), promisifiedQuery(query2)]);

    const orderFromSql1 = result1.rows;
    const orderFromSql2 = result2.rows;
    // console.log(orderFromSql2);
    for (const element of orderFromSql1) {
      const formattedDate = compareDatesWithNow(element.date);
      const formattedTime = checkTimeRange(element.time_from, element.time_to);
      const statusLamp = element.status_lamp.toLowerCase();
      if (formattedDate && formattedTime && statusLamp === 'off') {
          const data = await promisifiedQuery(`SELECT * FROM meja_controls WHERE billiard_id = ${element.biliard_id}`);
          console.log(data);
        const address = data.rows[0].address;
        await writeCoil(address, true);

        console.log('Update Lamp ON');
        await promisifiedQuery(`UPDATE orders SET status_lamp = 'ON', status_running = 'START' WHERE id = ${element.id}`);
      }
    }

    for (const element of orderFromSql2) {
      const formattedDate = compareDatesWithNow(element.date);
      const formattedTime = checkTimeRange(element.time_from, element.time_to);
      const formattedTime15Minutes = isWithinTimeRange(element.time_to);
      const statusLamp = element.status_lamp.toLowerCase();
      let statusRun = element.status_running.toLowerCase();

      if (formattedDate && formattedTime15Minutes && statusLamp === 'on' && statusRun === 'start') {
        const data = await promisifiedQuery(`SELECT * FROM meja_controls WHERE billiard_id = ${element.biliard_id}`);
        const address = data.rows[0].address;

        await writeCoil(address, false);
        await writeCoil(address, true);

        console.log('Update Status Running');
        await promisifiedQuery(`UPDATE orders SET status_running = 'ALMOST' WHERE id = ${element.id}`);
      }

      if (formattedDate && !formattedTime && statusLamp === 'on' && statusRun === 'almost') {
        const data = await promisifiedQuery(`SELECT * FROM meja_controls WHERE billiard_id = ${element.biliard_id}`);
        const address = data.rows[0].address;

        await writeCoil(address, false);

        console.log('Update Lamp OFF');
        await promisifiedQuery(`UPDATE orders SET status_lamp = 'OFF', status_running = 'DONE' WHERE id = ${element.id}`);
      }
    }
  } catch (error) {
    console.error('Error occurred:', error);
  }
}

function compareDatesWithNow(dbDate) {
  const currentDate = new Date();
  const dbDateObj = new Date(dbDate);
  currentDate.setHours(0, 0, 0, 0);
  dbDateObj.setHours(0, 0, 0, 0);
  return currentDate.getTime() === dbDateObj.getTime();
}

function checkTimeRange(timeFromDB, timeToDB) {
  const currentTime = new Date();
  const timeFromParts = timeFromDB.split(':');
  const timeToParts = timeToDB.split(':');
  const timeFrom = new Date();
  timeFrom.setHours(timeFromParts[0]);
  timeFrom.setMinutes(timeFromParts[1]);
  const timeTo = new Date();
  timeTo.setHours(timeToParts[0]);
  timeTo.setMinutes(timeToParts[1]);
  return currentTime >= timeFrom && currentTime <= timeTo;
}

function isWithinTimeRange(timeToDB) {
  const currentTime = new Date();
  const timeToParts = timeToDB.split(':');
  const targetTime = new Date();
  targetTime.setHours(timeToParts[0]);
  targetTime.setMinutes(timeToParts[1]);
  const fifteenMinutesBeforeTarget = new Date(targetTime.getTime() - 15 * 60000);
  return currentTime >= fifteenMinutesBeforeTarget && currentTime <= targetTime;
}

// *    *    *    *    *    *
// ┬    ┬    ┬    ┬    ┬    ┬
// │    │    │    │    │    │
// │    │    │    │    │    └ day of week (0 - 7) (0 or 7 is Sun)
// │    │    │    │    └───── month (1 - 12)
// │    │    │    └────────── day of month (1 - 31)
// │    │    └─────────────── hour (0 - 23)
// │    └──────────────────── minute (0 - 59)
// └───────────────────────── second (0 - 59, OPTIONAL)

// Reset ALL Stock

function updateCurrentStok() {
  // Ambil data terakhir dari tabel restaurants
  pool.query("SELECT id,stok_perhari FROM restaurants ORDER BY id ASC", (err, result) => {
    if (err) throw err;

    let allData = result.rows;

    allData.forEach(all => {
      // Pastikan ada hasil yang ditemukan
      if (result && result.rows.length > 0) {
        const lastStock = all.stok_perhari;
        const getID = all.id;
  
        // Perbarui current stok dari stok perhari
        pool.query(`UPDATE restaurants SET current_stok = ${lastStock}  WHERE id = ${getID}`, (err, updateResult) => {
          if (err) throw err;
          console.log("Stok diupdate menjadi: " + lastStock);
        });
      } else {
        console.log("Data stok tidak ditemukan.");
      }
    });
  });
}



  const updateStokJob = schedule.scheduleJob('0 06 * * *', function() {
    // console.log('sukses');
    // console.log('Scheduled job started at ' + new Date());
    updateCurrentStok();
});


// const InsertKodeMeja = schedule.scheduleJob('0 */06 * * *', function(){
//   pool.query("SELECT id,kode_meja FROM restaurants ORDER BY id ASC", (err, result) => {
//     if (err) throw err;
  
//     let allData = result.rows;
  
//     allData.forEach(all => {
//       // Pastikan ada hasil yang ditemukan
//       if (result && result.rows.length > 0) {
//         const mejaRestaurant = all.meja_restaurant_id;
//         const getID = all.id;
  
//         // Perbarui current stok dari stok perhari
//         pool.query(`UPDATE restaurants SET kode_meja = ${mejaRestaurant}  WHERE id = ${getID}`, (err, updateResult) => {
//           if (err) throw err;
//           console.log("Kode Meja Berhasil diupdate ");
//         });
//       } else {
//         console.log("Data kode Meja tidak ditemukan.");
//       }
//     });
//   });
// });

const InsertKodeMeja = schedule.scheduleJob('0 */06 * * *', function(){
  pool.query("UPDATE restaurants AS restaurant SET kode_meja = m.nama FROM meja_restaurant AS m WHERE restaurant.meja_restaurant_id = m.id", (err, result) => {
    if (err) throw err;

    if (result.rowCount > 0) {
      console.log("Kode Meja Berhasil diupdate ");
    } else {
      console.log("Data kode Meja tidak ditemukan.");
    }
  });
});

function updateKodeMeja() {
  pool.query("UPDATE orders AS o SET kode_meja = m.nama FROM meja_restaurants AS m WHERE o.meja_restaurant_id = m.id", (err, result) => {
    if (err) throw err;

    if (result.rowCount > 0) {
      console.log("Kode Meja Berhasil diupdate ");
    } else {
      console.log("Data kode Meja tidak ditemukan.");
    }
  });
}

updateKodeMeja();


app.post('/v1/api-control-lamp', async (req, res) => {
  try {
    const { addr, val } = req.body;
    console.log({ addr, val });
    await writeCoil(addr, val);
    res.status(200).send('Data Received');
  } catch (error) {
    console.error('Error occurred:', error);
    res.status(500).send('Error occurred');
  }
});

const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});