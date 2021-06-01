@extends('admin.layouts.app')
@section('content')
<div class="page-inner">
    <div id="main-wrapper">
        <div class="row">  
            @if(session()->has('message.level'))
            <div class="alert alert-{{ session('message.level') }}"> 
                {!! session('message.content') !!}
            </div>
            @endif
            <div class="col-md-12">
                <div class="panel panel-white">
                  
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">User Management</h4>
                          @if(!empty($is_admin))
                        <a href="{{route('admin.users.create')}}" class="btn btn-success m-l-sm m-r-sm" style="float: right;">Add User</a>
                        @endif
                    </div>
                    
                </div>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">User List</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                         @if(!empty($is_admin))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                         @if(!empty($is_admin))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($users))
                                    @foreach ($users as $key =>$user) 
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{$user->email }}</td>
                                        <td>{{$user->mobile_number }}</td>
                                        <td><span class="user-role {{$user->roles[0]->name}}">{{$user->roles[0]->name }}</span></td>
                                        <td>{{$user->is_active ==1 ?'Active' : 'Inactive' }}</td>
                                         @if(!empty($is_admin))
                                        <td><a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-rounded btn-warning"><i class="fa fa-pencil">&nbsp;Edit</i></a>&nbsp;<form method="POST" action="{{route('admin.users.destroy',$user->id)}}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-rounded btn-danger confirmdel"><i class="fa fa-close">&nbsp;Delete</i></button>
                                                </div>
                                            </form>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach        
                                    @endif
                                </tbody>
                            </table>  
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Row -->
    </div><!-- Main Wrapper -->
</div>
@endsection