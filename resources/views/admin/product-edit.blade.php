@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{route('admin.products')}}">
                        <div class="text-tiny">Products</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit product</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.update')}}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{$product->id}}" />
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0" value="{{$product->name}}" aria-required="true" required="">
                </fieldset>
                @error('name') <span class="alert alert-danger text-center">{{$message}} @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0" value="{{$product->slug}}" aria-required="true" required="">
                </fieldset>
                @error('slug') <span class="alert alert-danger text-center">{{$message}} @enderror

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true" required="">{{$product->description}}</textarea>
                </fieldset>
                @error('description') <span class="alert alert-danger text-center">{{$message}} @enderror
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if($product->image)
                        <div class="item" id="imgpreview">
                            <img src="{{asset('uploads/products')}}/{{$product->image}}" class="effect8" alt="{{$product->name}}">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{$message}} @enderror

                <fieldset>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    <div class="upload-image mb-16">
                        @if($product->images)
                            @foreach(explode(',',$product->images) as $img)
                            <div class="item gitems">
                                <img src="{{asset('uploads/products')}}/{{trim($img)}}" alt="">
                            </div>
                            @endforeach
                        @endif
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*" multiple="">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('images') <span class="alert alert-danger text-center">{{$message}} @enderror

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Price <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter price" name="price" tabindex="0" value="{{$product->price}}" aria-required="true" required="">
                    </fieldset>
                    @error('price') <span class="alert alert-danger text-center">{{$message}} @enderror
                </div>


                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity" tabindex="0" value="{{$product->quantity}}" aria-required="true" required="">
                    </fieldset>
                    @error('quantity') <span class="alert alert-danger text-center">{{$message}} @enderror
                </div>

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Update product</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
</div>

@endsection

@push("scripts")
    <script>
            $(function(){
                $("#myFile").on("change",function(e){
                    const photoInp = $("#myFile");                    
                    const [file] = this.files;
                    if (file) {
                        $("#imgpreview img").attr('src',URL.createObjectURL(file));
                        $("#imgpreview").show();                        
                    }
                });


                $("#gFile").on("change",function(e){
                    $(".gitems").remove();
                    const gFile = $("gFile");
                    const gphotos = this.files;                    
                    $.each(gphotos,function(key,val){                        
                        $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}" alt=""></div>`);                        
                    });                    
                });


                $("input[name='name']").on("change",function(){
                    $("input[name='slug']").val(StringToSlug($(this).val()));
                });
                
            });
            function StringToSlug(Text) {
                return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
            }      
    </script>
@endpush