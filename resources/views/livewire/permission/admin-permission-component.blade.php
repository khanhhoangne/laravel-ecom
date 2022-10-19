<main id="main" class="main">
    <div class="pagetitle">
        <h1>Danh sách quyền hạn</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Tổng quan</a></li>
                <li class="breadcrumb-item">Danh sách quyền hạn</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row rowHeader">
                            <div class="col-md-6">
                                <h5 class="card-title">Danh sách quyền hạn</h5>
                            </div>
                        </div>
                        

                        <!-- Table with stripped rows -->
                        <table class="table" id="listtable">
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">Thứ tự</th>
                                    <th width="20%" scope="col">Tên</th>
                                    <th width="23%" scope="col">Slug</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($permissions as $permission)
                                <tr class="listViewTableRow">   
                                    <th scope="row">{{$i}}</th>
                                    <td>{{$permission->name}}</td>
                                    <td>{{$permission->slug}}</td>
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


