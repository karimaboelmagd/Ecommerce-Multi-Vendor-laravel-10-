@extends('backend.layouts.master')


@section('content')

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Categories</h2>
                        <ul class="breadcrumb float-left">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Category</li>
                        </ul>
                        <p class="float-right">Total Categories : {{App\Models\Category::count()}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    @include('backend.layouts.notification')
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Category</strong> List</h2>
                            <br>
                            <a href="{{route('category.create')}}" class="btn btn-primary btn-sm float-left" data-toggle="tooltip" data-placement="bottom" title="Add Category"><i class="fas fa-plus"></i> Add Category</a>
                            <br>
                        </div>

                        <div class="body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Photo</th>
                                        <th>Is Parent</th>
                                        <th>Parents</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($categories as $item)
                                        <tr>
                                            <th>{{$loop->iteration}}</th>
                                            <th>{{$item->title}}</th>
                                            <th>
                                                <img src="{{$item->photo}}" class="img-fluid zoom" style="max-width:80px" alt="{{$item->photo}}">
                                            </th>
                                            <th>{{(($item->is_parent==1)? 'Yes': 'No')}}</th>
                                            <th>{{\App\Models\Category::where('id',$item->parent_id)->value('title')}}</th>
                                            <th>
                                                <input type="checkbox" name="toogle" value="{{$item->id}}" data-toggle="switchbutton"
                                                       {{$item->status=='active' ? 'checked' : ''}} data-onlabel="Active" data-offlabel="Inactive"
                                                       data-size="sm" data-onstyle="success" data-offstyle="danger">
                                            </th>

                                            <th>
                                                <a href="{{route('category.edit', $item->id)}}" data-toggle="tooltip" title="Edit" class="float-left btn btn-sm btn-outline-warning" data-placement="bottom">
                                                    <i class=" fas fa-edit"></i>
                                                </a>

                                                <form class="float-left ml-1" action="{{route('category.destroy', $item->id)}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <a href="" data-toggle="tooltip" title="Delete" data-id="{{$item->id}}" class="dltBtn btn btn-sm btn-outline-danger" data-placement="bottom">
                                                        <i class=" fas fa-trash-alt">
                                                        </i>
                                                    </a>
                                                </form>
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    {{--    <script>--}}
    {{--        $('input[name=toogle]').change(function (){--}}
    {{--            var mode=$(this).prop('checked');--}}
    {{--            var id=$(this).val();--}}

    {{--            $.ajax({--}}
    {{--                url:"{{route('category.status')}}",--}}
    {{--                type:'POST',--}}
    {{--                data:{--}}
    {{--                    _token:'{{csrf_token()}}',--}}
    {{--                    mode:mode,--}}
    {{--                    id:id,--}}
    {{--                },--}}
    {{--                success:function (response){--}}
    {{--                   if(response.status){--}}
    {{--                       alert(response.msg);--}}
    {{--                   }--}}
    {{--                   else{--}}
    {{--                       alert('Please Try Again!')--}}
    {{--                   }--}}
    {{--                }--}}
    {{--            })--}}
    {{--        });--}}
    {{--    </script>--}}

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e){
                var form=$(this).closest('form');
                var dataID=$(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete the Category!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        })
    </script>

@endsection
