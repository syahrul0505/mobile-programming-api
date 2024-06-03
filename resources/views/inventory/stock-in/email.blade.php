<div class="row mt-4">
    <div class="col-lg-6">
        <div style="border-radius: 15px">
            <div class="card-body">
                {{-- {{ dd($data['email'][0]) }} --}}
                {{-- <img src="{{ asset('assets/images/logo/vmond-logo-head.png') }}" style="width: 200px; height:100px;" alt=""> --}}
                {{-- <h1>tes</h1> --}}
            </div>

            <div>
                    
                <div>
                    <p>Action : {{ $permit->action }}</p>
                </div>

                <div>
                    <p>Page : {{ $permit->page }}</p>
                </div>

                <div>
                    <p>Date : {{ $permit->datetime }}</p>
                </div>

                <div>
                    <p>Status : {{ $permit->status }}</p>
                </div>

                <div>
                    <p>Description : {{ $permit->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>