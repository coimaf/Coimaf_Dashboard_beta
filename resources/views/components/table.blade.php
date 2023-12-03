<div class="container-fluid main-content">
    <div class="row justify-content-center align-items-center">
        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 rounded-2 mt-3" style="background-color: rgb(243, 243, 243); height: 88vh;">
            <div class="col-12 rounded-2 mt-3" style="max-height: 77vh; overflow-y: scroll">
                @if(is_array($rowData) && count($rowData) > 0)
                    <div class="table-responsive content-main">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr class="text-center align-middle">
                                    <th scope="col"><input type="checkbox"></th>
                                    @foreach ($columnTitles as $title)
                                        <th scope="col">{{ $title }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center align-middle">
                                    <th scope="row" class="p-4"><input type="checkbox"></th>
                                    @foreach ($rowData as $data)
                                        <td class="p-4">{!! $data !!}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center" style="height: 77vh;">
                        <p class="text-center fs-4">Nessun dato disponibile.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


