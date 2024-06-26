@extends('backend.layouts.master')

@section('content')

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a>Add Product</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Products</li>
                            <li class="breadcrumb-item active">Add Product</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                     @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{\session()->get('success')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                     @endif

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">

                        <div class="body">
                            <form action="{{route('product.store')}}" method="post">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Title<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Title" name="title" value="{{old('title')}}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Summary<span class="text-danger">*</span></label>
                                        <textarea id="summary" class="form-control" placeholder="Write Some Text...." name="summary">{{old('summary')}}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Description<span class="text-danger">*</span></label>
                                        <textarea id="description" class="form-control" placeholder="Write Some Text...." name="description">{{old('description')}}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Stock<span class="text-danger">*</span></label>
                                        <input id="stock" type="number" class="form-control" placeholder="Stock" name="stock" value="{{old('stock')}}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Price<span class="text-danger">*</span></label>
                                        <input id="price" type="number" step="any" class="form-control" placeholder="Price" name="price" value="{{old('price')}}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Discount</label>
                                        <input id="discount" type="number" min="0" max="100" step="any" class="form-control" placeholder="Discount" name="discount" value="{{old('discount')}}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Photo</label>
                                        <div class="input-group">
                                           <span class="input-group-btn">
                                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                               <i class="fa fa-picture-o"></i> Choose
                                             </a>
                                           </span>
                                            <input id="thumbnail" class="form-control" type="text" name="photo">
                                        </div>
                                        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Brand</label>
                                    <select name="brand_id" class="form-control show-tick">
                                        <option value="">-- Brand --</option>
                                        @foreach(\App\Models\Brand::get() as $brand)
                                            <option value="{{$brand->id}}" {{old('brand_id')==$brand->id? 'selected' : ''}}>{{$brand->title}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="cat_id">Category</label>
                                    <select id="cat_id" name="cat_id" class="form-control show-tick">
                                        <option value="">-- Category --</option>
                                        @foreach(\App\Models\Category::where('is_parent',1)->get() as $category)
                                            <option value="{{$category->id}}" {{old('cat_id')==$category->id? 'selected' : ''}}>{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 d-none" id="child_cat_div">
                                    <label for="">Sub Category</label>
                                    <select id="chil_cat_div" name="child_cat_id" class="form-control show-tick">
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Size</label>
                                    <select name="size" class="form-control show-tick">
                                        <option value="">-- Size --</option>
                                        <option value="S" {{old('size'== 'S' ? 'selected' : '')}}>Small</option>
                                        <option value="M" {{old('size'== 'M' ? 'selected' : '')}}>Medium</option>
                                        <option value="L" {{old('size'== 'L' ? 'selected' : '')}}>Large</option>
                                        <option value="XL" {{old('size'== 'XL' ? 'selected' : '')}}>Extra Large</option>
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Condition</label>
                                    <select id="condition" name="condition" class="form-control show-tick">
                                        <option value="">-- Condition --</option>
                                        <option value="new" {{old('condition'== 'new' ? 'selected' : '')}}>New</option>
                                        <option value="popular" {{old('condition'== 'popular' ? 'selected' : '')}}>Popular</option>
                                        <option value="winter" {{old('condition'== 'winter' ? 'selected' : '')}}>Winter</option>
                                    </select>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="">Vendors</label>
                                    <select id="vendor_id" name="vendor_id" class="form-control show-tick">
                                        <option value="">-- Vendors --</option>
                                        @foreach(\App\Models\User::where('role','vendor')->get() as $vendor)
                                            <option value="{{$vendor->id}}" {{old('vendor_id')==$vendor->id? 'selected' : ''}}>{{$vendor->full_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-12 col-sm-12">
                                    <label for="">Status</label>
                                    <select id="status" name="status" class="form-control show-tick">
                                        <option value="">-- Status --</option>
                                        <option value="active" {{old('status'== 'active' ? 'selected' : '')}}>Active</option>
                                        <option value="inactive" {{old('status'== 'inactive' ? 'selected' : '')}}>Inactive</option>
                                    </select>
                                </div>


                            </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="submit" class="btn btn-outline-secondary">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')

    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script>
        $('#lfm').filemanager('image');
    </script>

    <script>
        $(document).ready(function() {
            $('#description').summernote();
        });
    </script>

     <script>
         $(document).ready(function() {
             $('#summary').summernote();
         });
      </script>


     <script>

         $('#cat_id').change(function(){
             var cat_id=$(this).val();
             // alert(cat_id);
             if(cat_id !=null){
                 // Ajax call
                 $.ajax({
                     url:"/admin/category/"+cat_id+"/child",
                     type: "POST",
                     data:{
                         _token:"{{csrf_token()}}",
                         cat_id:cat_id
                     },
                     success:function(response) {
                         var html_option = "<option value=''>--Select Sub Category--</option>"
                         if (response.status) {
                             $('#child_cat_div').removeClass('d-none');
                             $.each(response.data, function (id, title) {
                                 html_option += "<option value='" + id + "'>" + title + "</option>"
                             });
                     }
                         else{
                             $('#child_cat_div').addClass('d-none');
                         }
                         $('#chil_cat_div').html(html_option);

                     }

                 });
             }
         });
     </script>
@endsection
