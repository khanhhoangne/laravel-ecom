<main id="main" class="main">
    <div class="pagetitle">
        <h1>Danh sách module quản lý</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Danh sách module quản lý</li>
                <li class="breadcrumb-item active"><a href="{{route('commands')}}">Tất cả</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row rowHeader">
                            <div class="col-md-6">
                                <h5 class="card-title">Danh sách module quản lý</h5>
                            </div>
                        </div>
                        

                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">Thứ tự</th>
                                    <th width="20%" scope="col">Tên</th>
                                    <th width="23%" scope="col">Mô tả</th>
                                    <th width="23%" scope="col">Slug</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($commands as $command)
                                <tr class="listViewTableRow">   
                                    <th scope="row">{{$i}}</th>
                                    <td>{{$command->name}}</td>
                                    <td>{{$command->description}}</td>
                                    <td>{{$command->slug}}</td>
                                </tr>
                                @php
                                $i++;
                                @endphp                            
                            @endforeach

                            </tbody>
                        </table>

                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

@push('scripts')
    <script>
        Livewire.restart();
    </script>
@endpush


