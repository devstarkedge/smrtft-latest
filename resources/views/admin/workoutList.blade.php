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
           
            <div class="col-sm-12">
                <div class="trainer-title">
                     <h4 class="trainer-name">Trainer Name <span class="name-style">{{$trainerName}}</span></h4>   
                </div>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Workout List </h4>        
                        
                        
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th hidden>Trainer Name</th>
                                        <th>SubCategory</th>
                                        <th>WorkOut Name</th>
                                        <th>WorkOut Description </th>
                                        <th>WorkOut Image </th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Workout Exercises</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th hidden>Trainer Name</th>
                                        <th>SubCategory</th>
                                        <th>WorkOut Name</th>
                                        <th>WorkOut Description </th>
                                        <th>WorkOut Image </th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Workout Exercises</th>
                                    </tr>
                                </tfoot>
                                <tbody id="sortable">
                                    @if(isset($workoutList))
                                    @foreach ($workoutList as $details) 
                                    <tr>
                                        <td hidden>{{ $details->first_name }}</td>
                                        <td  class="clsworkoutid" hidden>{{ $details->id }}</td>
                                        <td  class="clsposition" hidden>{{ $details->position }}</td>
                                        <td>{{$details->subcategory_name }}</td>
                                        <td>{{$details->workout_name }}</td>
                                        <td>{{$details->workout_desc }}</td>
                                        <td><img src="{{ asset('/workoutimage/'.$details->workout_image)}}" alt="" title="" width="100px;" height="100px;" /></td>
                                        
                                        <td>{{$details->workout_time }}</td>
                                        <td>{{!empty($details->workout_status)?"Active":"Deactive" }}</td>
                                         <td><a href="{{route('admin.workout.edit',$details->id)}}"><i class="fa fa-edit"></i></a><!-- <a href="#"><i class="fa fa-trash"></i></a> --></td>
                                         <td><a href="{{route('admin.workout.exercises',$details->id)}}"> Details
                                    </a></td>
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
<button id="second" hidden>test</button>
<script type="text/javascript">
        $(function() {
            $("#sortable tr").draggable({
                appendTo: "body",
                helper: "clone",
                cursor: "move",
                revert: "invalid"
            });
 
            initDroppable($("#sortable tr"));
            function initDroppable($elements) {
                $elements.droppable({
                    activeClass: "ui-state-default",
                    hoverClass: "ui-drop-hover",
                    accept: ":not(.ui-sortable-helper)",
 
                    over: function(event, ui) {
                        var $this = $(this);
                    },
                    drop: function(event, ui) {
                        var $this = $(this);
                        var li1 = $('<tr>' + ui.draggable.html() + '</tr>')
                        var linew1 = $(this).after(li1);
 
                        var li2 = $('<tr>' + $(this).html() + '</tr>')
                        var linew2 = $(ui.draggable).after(li2);
                        var get_id = $(ui.draggable.children('td.clsworkoutid').text());
                        var get_pos = $(ui.draggable.children('td.clsposition').text());
                        var get_id1 = $($(this).children('td.clsworkoutid').text());
                        var get_pos1 = $($(this).children('td.clsposition').text());
                        localStorage.setItem("get_id", get_id.selector);
                        localStorage.setItem("get_pos", get_pos.selector);
                        localStorage.setItem("get_id1", get_id1.selector);
                        localStorage.setItem("get_pos1", get_pos1.selector);

                       
                        //$(li1).children('td.clsworkoutid').text(get_id1.selector);
                        $(li1).children('td.clsposition').text(get_pos1.selector);
                        //$(li2).children('td.clsworkoutid').text(get_id.selector);
                        $(li2).children('td.clsposition').text(get_pos.selector);
 
                        console.log(get_pos.selector);
                        $(ui.draggable).remove();
                        $(this).remove();
                        $("#second").click()
                        initDroppable($("#sortable tr"));
                        $("#sortable tr").draggable({
                            appendTo: "body",
                            helper: "clone",
                            cursor: "move",
                            revert: "invalid"
                        });

                    }
                });
            }
        });

        $('#second').click(function(){
             upadtePositon();
        });

        function upadtePositon()
        {

            var get_id = localStorage.getItem("get_id", get_id);
            var get_pos = localStorage.getItem("get_pos", get_pos);
            var get_id1 = localStorage.getItem("get_id1", get_id1);
            var get_pos1 = localStorage.getItem("get_pos1", get_pos1);
            //ajax call start

                         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       
         $.ajax({
              method:'POST',
              url:"{{route('admin.workout.index.update')}}",    
              enctype: 'multipart/form-data',
              data:{
                  "workout_id": get_id,
                  "position_id":get_pos,
                  "workout_id1":get_id1,
                  "position_id1":get_pos1
                  
              },
            success: function(response) {
                  
                  alert(response);
        
                 
              }
          });




                        //ajax call end
        }
    </script>
@endsection