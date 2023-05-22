@extends('layouts.app')
@section('content')

<div class="container">
  <h1 class="mb-5 mt-5">Users</h1>
  @if(auth()->user()->is_admin ==  1)
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
    Add User
  </button>
  @endif

  <table class="table table-bordered data-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>email</th>
      
        <th>action</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<!-- Add New User -->
<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserLabel">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('user.store') }}" method="POST" id="addUserForm">
        @csrf
        <div class="modal-body">

          <div class="form-group mt-2">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Name" />
        </div>

        <div class="form-group mt-2">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control" id="email" placeholder="Email" />
      </div>

      <div class="form-group mt-2">
        <label for="email">Password</label>
        <input type="text" name="password" class="form-control" id="password"
        placeholder="Password" />
    </div>
    <div class="form-group mt-2">
      <label for="email">Confirm Password</label>
      <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
      placeholder="Confirm Password" />
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

<!-- edit New User -->
<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="editUserLabel">Edit User #<span id="edit_user_id">0</span></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="#" method="POST" id="editUserForm">
@csrf
@method("PUT")
<div class="modal-body" id="edit_user_body">

<div class="form-group mt-2">
<label for="name">Name</label>
<input type="text" name="name" class="form-control" id="edit_name" placeholder="Name" />
</div>

<div class="form-group mt-2">
<label for="email">Email</label>
<input type="email" name="email" class="form-control" id="edit_email" placeholder="Email" />
</div>

<!-- <div class="form-group mt-2">
<label for="email">Password</label>
<input type="text" name="password" class="form-control" id="edit_password"
placeholder="[" />
</div>

<div class="form-group mt-2">
<label for="email">Confirm Password</label>
<input type="password" name="password_confirmation" class="form-control" id="edit_password_confirmation"
placeholder="Confirm Password" />
</div> -->

</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary">Edit</button>
</div>
</form>
</div>
</div>
</div>


@endsection

@push('js')
<script type="text/javascript">
$(function() {
var table = $('.data-table').DataTable( {
processing: true,
serverSide: true,
ajax: "{{ route('user.index') }}",
columns: [{
data: 'DT_RowIndex',
name: 'DT_RowIndex'
},
{
data: 'name',
name: 'name'
},
{
data: 'email',
name: 'email'
},

{
data: 'action',
name: 'action'
},
]
});

$(document).on('click', '.user-delete', function(e) {
if (confirm('are you sure .!')) {
var user_id = $(this).attr('data-user_id');
var user_delete_url = '{{ route("user.destroy","DUMMY") }}';
user_delete_url = user_delete_url.replace('/DUMMY', '/' + user_id);

$.ajax( {
url: user_delete_url,
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

//Add User start
$('#addUserForm').bootstrapValidator( {
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
email: {
validators: {
notEmpty: {
message: 'Email is required and cannot be empty'
}
}
},


password: {
validators: {
notEmpty: {
message: 'password is required and cannot be empty'
}
}
},

password_confirmation: {
validators: {
notEmpty: {
message: 'password is required and cannot be empty'
}, identical: {
field: 'password',
message: 'The password confirmation must match. '
},
}
},
},
}).on('success.form.bv', function(e) {
e.preventDefault();
var formData = new FormData(this)
var form = $(e.target);

//var bv = $form.data('bootstrapValidator');
$.ajax( {
url: form.attr('action'),
type: "POST",
data: formData,
success: function(data) {
if (data.status == 200) {
$('#addUserForm').trigger('reset');
$('#addUser').modal('hide');
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
//Add User end

//Edit User start

$('#editUserForm').bootstrapValidator( {
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
email: {
validators: {
notEmpty: {
message: 'Email is required and cannot be empty'
}
}
},
passwod: {
validators: {
notEmpty: {
message: 'password is required and cannot be empty'
}
}
},
password_confirmation: {
validators: {
notEmpty: {
message: 'password is required and cannot be empty'
}, identical: {
field: 'password',
message: 'The passwords must match. '
},
}
},
},
}).on('success.form.bv', function(e) {
e.preventDefault();
let formDataUpdate = new FormData(this);
var form = $(e.target);
$.ajax( {
url: form.attr('action'),
type: 'post',
processData: false,
contentType: false,
data: formDataUpdate,
success: function(data) {
if (data.status == 200) {
$('#editUserForm').trigger('reset');
$('#editUser').modal('hide');
toastr.success(data.message);
table.ajax.reload();
$('#priview_image').html(' ');
} else {
toastr.error(data.message);
}
}
});

});
//Edit User end

$(document).on('click', '.user-edit', function(e) {
var user_id = $(this).attr('data-user_id');
var user_get_url = '{{ route("user.edit","DUMMY") }}';
user_get_url = user_get_url.replace('/DUMMY',
'/' + user_id);

$.ajax( {
url: user_get_url,
type: "GET",
success: function(data) {
if (data.status == 200) {
console.log('data', data);
var user_update_url = '{{ route("user.update","DUMMY") }}';
user_update_url = user_update_url.replace('/DUMMY', '/' + data.result.id);
$('#editUserForm').attr('action', user_update_url);
$('#edit_user_id').text(data.result.id);
$('#edit_user_body #edit_name').val(data.result.name);
$('#edit_user_body #edit_email').val(data.result.email);
$('#edit_user_body #edit_category').val(data.result.category_id);
$('#edit_user_body #edit_password').val(data.result.password);
$('#edit_user_body #edit_description').val(data.result.description);
$('#edit_user_body #edit_priview_image').show();

$('#editUser').modal('show');
var imagePrivew = '';
if (data.result.images) {
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
@endpush