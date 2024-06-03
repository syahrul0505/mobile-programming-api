const ModbusRTU = require("modbus-serial");
const client = new ModbusRTU();

function connectToModbus() {
  return new Promise((resolve, reject) => {
    client.connectTCP("192.168.18.22", { port: 502 }, (err) => {
      if (err) {
        reject(new Error("Error connecting to Modbus TCP"));
      } else {
        client.setID(1);
        resolve();
      }
    });
  });
}

async function writeCoil(addr, val) {
  try {
    await connectToModbus();
    const boolVal = val === "true" || val === true;
    console.log(boolVal);
    client.writeCoil(addr, boolVal, (err, data) => {
      if (err) {
        console.error("Error occurred:", err);
      } else {
        console.log("Write successful. Response data:", data);
      }
    });
  } catch (error) {
    console.error("Error occurred:", error.message);
  }
}

module.exports = writeCoil;
