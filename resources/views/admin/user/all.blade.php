@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách thương hiệu sản phẩm
    </div>
    <div class="row w3-res-tb">
      <?php 
          $message = Session::get('message');
          if($message){
              echo '<span class="text-alert">',$message,'</span>';
              Session::put('message', null);
          }

      ?>
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên người dùng</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Author</th>
            <th>Admin</th>
            <th>User</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($admin as $key => $ad_user)
            <form action="{{URL::to('/assign-roles')}}" method="POST">
                @csrf
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{$ad_user->admin_name}}</td>
                    <td>{{$ad_user->admin_mail}}
                        <input type="hidden" name="admin_email" value="{{$ad_user->admin_mail}}">
                    </td>
                    <td>{{$ad_user->admin_phone}}</td>
                    <td>
                        <input type="checkbox" name="author_role" {{$ad_user->hasRole('author') ? 'checked' : ''}} >
                    </td>
                    <td>
                        <input type="checkbox" name="admin_role" {{$ad_user->hasRole('admin') ? 'checked' : ''}} >
                    </td>
                    <td>
                        <input type="checkbox" name="user_role" {{$ad_user->hasRole('user') ? 'checked' : ''}} >
                    </td>
                </tr>
            </form>
          @endforeach
          
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection