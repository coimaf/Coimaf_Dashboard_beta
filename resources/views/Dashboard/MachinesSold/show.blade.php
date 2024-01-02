<x-Layouts.layoutDash>
    <section class="m-5" style="background-color: rgb(243, 243, 243); height: 86vh; overflow:auto">
        <div class="container p-5">
            <div class="row text-center justify-content-center">
                <div class="col-lg-4">
                    <div class="card mb-4 text-black">
                        <div class="card-body text-center">
                            <h5 class="my-3 fs-3 fw-bold text-alt">{{$machine->model}}</h5>
                            <p>{{$machine->brand}}</p>
                            <p>{{$machine->serial_number}}</p>
                            <p>{{$machine->sale_date}}</p>
                            <p>{{$machine->first_buyer}}</p>
                            <p>{{$machine->current_owner}}</p>
                            <p>{{$machine->warranty_expiration_date}}</p>
                            <p>{{$machine->warrantyType->name}}</p>
                            <p>{{$machine->registration_date}}</p>
                            <p>{{$machine->delivery_ddt}}</p>
                            <p>{{$machine->notes}}</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-Layouts>
