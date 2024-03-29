<div class="bg-white rounded shadow p-4">
    <h3><strong>{{ $chartTitle6 }}</strong></h3>

    {{-- chart --}}
    <div class="container">
        <div class="">
            {!! $chart6->container() !!}
        </div>
        <br><br>
        <div class="">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col-9">Tahun</th>
                        <th scope="col-1">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($data as $row)
                        <tr>
                            <th scope="row">{{ $row->title }}</th>
                            <td>{!!  $row->content  !!}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="{{ $chart6->cdn() }}"></script>

{{ $chart6->script() }}