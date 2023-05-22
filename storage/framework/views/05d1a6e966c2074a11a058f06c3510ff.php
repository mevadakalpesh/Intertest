<?php $__env->startSection('content'); ?>

<div class="container">
    <h1 class="mb-5 mt-5">Products</h1>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
  Add Product
</button>
<table class="table table-bordered data-table">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Price</th>
      <th>package</th>
      <th>QTY (KG)</th>
      <th>Created At</th>
      <th>action</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
</div>

<!-- Add New Product -->
<div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductLabel">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo e(route('product.store')); ?>" method="POST" id="addUserForm">
        <?php echo csrf_field(); ?>
        <div class="modal-body">

          <div class="form-group mt-2">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Name" />
          </div>

          <div class="form-group mt-2">
            <label for="price">Price</label>
            <input type="text" name="price" class="form-control" id="price" placeholder="Price" min="1" />
          </div>

          <div class="form-group mt-2">
            <label for="price">QTY</label>
            <input type="text" name="qty" class="form-control" id="qty" placeholder="QTY" min="1" />
          </div>

          <div class="form-group mt-2">
            <label for="package">Package</label>
            <select name="package" class="form-control" id="package">
                <option value="KG">Killo Grams</option>
                <option value="MG">Mill Grams</option>
                <option value="GM">Grams</option>
            </select>
          </div>

          <div class="form-group mt-2">
            <label for="image">Image</label>
            <input multiple name="image[]" type="file" class="form-control" id="image" placeholder="Image">
            <div id="priview_image">

            </div>

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- edit New Product -->
<div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductLabel">Edit Product #<span id="edit_product_id">0</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="editUserForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field("PUT"); ?>
        <div class="modal-body" id="edit_product_body">

          <div class="form-group mt-2">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="edit_name" placeholder="Name" />
          </div>

          <div class="form-group mt-2">
            <label for="price">Price</label>
            <input type="text" name="price" class="form-control" id="edit_price" placeholder="Price" min="1" />
          </div>

          <div class="form-group mt-2">
            <label for="price">QTY</label>
            <input type="text" name="qty" class="form-control" id="edit_qty" placeholder="QTY" min="1" />
          </div>

          <div class="form-group mt-2">
            <label for="package">Package</label>
            <select name="package" class="form-control" id="edit_package">
              <option value="KG">Killo Grams</option>
              <option value="MG">Mill Grams</option>
              <option value="GM">Grams</option>
            </select>
          </div>

          <div class="form-group mt-2">
            <label for="image">Image</label>
            <input multiple name="image[]" type="file" class="form-control" id="edit_image" placeholder="Image">

            <div id="edit_priview_image">

            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script type = "text/javascript" >
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('product.index')); ?>",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'package',
                    name: 'package'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });

        $(document).on('click', '.product-delete', function(e) {
            if (confirm('are you sure .!')) {
                var product_id = $(this).attr('data-product_id');
                var product_delete_url = '<?php echo e(route("product.destroy","DUMMY")); ?>';
                product_delete_url = product_delete_url.replace('/DUMMY', '/' + product_id);

                $.ajax({
                    url: product_delete_url,
                    type: "DELETE",
                    success: function(data) {
                        if (data.status == 200) {
                            table.ajax.reload();
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });

        //Add Product start
        $('#addUserForm').bootstrapValidator({
            live: 'enabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Name is required and cannot be empty'
                        }
                    }
                },
                price: {
                    validators: {
                        notEmpty: {
                            message: 'Price is required and cannot be empty'
                        }
                    }
                },
                qty: {
                    validators: {
                        notEmpty: {
                            message: 'QTY is required and cannot be empty'
                        }
                    }
                },
                package: {
                    validators: {
                        notEmpty: {
                            message: 'package is required and cannot be empty'
                        }
                    }
                },
                image: {
                    validators: {
                        notEmpty: {
                            message: 'Image is required and cannot be empty'
                        },
                    }
                }
            },
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            var formData = new FormData(this)
            var form = $(e.target);

            //var bv = $form.data('bootstrapValidator');
            $.ajax({
                url: form.attr('action'),
                type: "POST",
                data: formData,
                success: function(data) {
                    if (data.status == 200) {
                        $('#addUserForm').trigger('reset');
                        $('#addProduct').modal('hide');
                        toastr.success(data.message);
                        table.ajax.reload();
                        $('#priview_image').html(' ');
                    } else {
                        toastr.error(data.message);
                    }

                },
                error: function(e) {
                    console.log(e);
                    alert(e);
                },
                cache: false,
                contentType: false,
                processData: false

            })
        });
        //Add Product end

        //Edit Product start

        $('#editUserForm').bootstrapValidator({
            live: 'enabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Name is required and cannot be empty'
                        }
                    }
                },
                price: {
                    validators: {
                        notEmpty: {
                            message: 'Price is required and cannot be empty'
                        }
                    }
                },
                package: {
                    validators: {
                        notEmpty: {
                            message: 'package is required and cannot be empty'
                        }
                    }
                },
            },
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            let formDataUpdate = new FormData(this);
            var form = $(e.target);
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                processData: false,
                contentType: false,
                data: formDataUpdate,
                success: function(data) {
                    if (data.status == 200) {
                        $('#editUserForm').trigger('reset');
                        $('#editProduct').modal('hide');
                        toastr.success(data.message);
                        table.ajax.reload();
                        $('#priview_image').html(' ');
                    } else {
                        toastr.error(data.message);
                    }
                }
            });

        });
        //Edit Product end

        $(document).on('click', '.product-edit', function(e) {
            var product_id = $(this).attr('data-product_id');
            var product_get_url = '<?php echo e(route("product.edit","DUMMY")); ?>';
            product_get_url = product_get_url.replace('/DUMMY', '/' + product_id);

            $.ajax({
                url: product_get_url,
                type: "GET",
                success: function(data) {
                    if (data.status == 200) {
                        console.log('data', data);
                        var product_update_url = '<?php echo e(route("product.update","DUMMY")); ?>';
                        product_update_url = product_update_url.replace('/DUMMY', '/' + data.result.id);
                        $('#editUserForm').attr('action', product_update_url);
                        $('#edit_product_id').text(data.result.id);
                        $('#edit_product_body #edit_name').val(data.result.name);
                        $('#edit_product_body #edit_price').val(data.result.price);
                        $('#edit_product_body #edit_package').val(data.result.package);
                        $('#edit_product_body #edit_qty').val(data.result.qty);
                        $('#edit_product_body #edit_priview_image').show();

                        $('#editProduct').modal('show');
                        var imagePrivew = '';
                        if( data.result.images){
                            data.result.images.forEach(element => {
                                imagePrivew += '<img  class="listing-image" src="'+element.image+'" alt="preview" />';
                            });
                        }
                        $('#edit_priview_image').html(imagePrivew);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(e) {
                    console.log(e);
                },
                cache: false,
                contentType: false,
                processData: false
            })
        });


        $('#priview_image').hide();
        $('#priview_image').html(' ');
        $('#image').change(function(e) {
            $('#priview_image').show();
            var imagePrivew = '';
            for (let index = 0; index < this.files.length; index++) {
                 imagePrivew += '<img  class="listing-image" src="'+URL.createObjectURL(this.files[index])+'" alt="preview" />';
            }
            $('#priview_image').html(imagePrivew);
        });


        $('#edit_priview_image').hide();
        $('#edit_priview_image').html(' ');
        $('#edit_image').change(function(e) {
            $('#edit_priview_image').show();
            var imagePrivew = '';
            for (let index = 0; index < this.files.length; index++) {
                 imagePrivew += '<img  class="listing-image" src="'+URL.createObjectURL(this.files[index])+'" alt="preview" />';
            }
            $('#edit_priview_image').html(imagePrivew);
        });



    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\intpro\resources\views/products/product-listing.blade.php ENDPATH**/ ?>