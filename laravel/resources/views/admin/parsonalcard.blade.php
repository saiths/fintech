@include('admin.common.main2')
<div class="page-wrapper"> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <style>
                    a:hover {
                        color : white;
                    }
                </style>
                <!--<h4 class="card-title m-t-40">Parsonal Note</h4>-->
                <div class="row" id="card-colors">
                    <style>
                        .cards {
                            position: relative;
                            /* display: flex; */
                            flex-direction: column;
                            min-width: 0;
                            word-wrap: break-word;
                            background-color: #fff;
                            background-clip: border-box;
                            border: 0 solid transparent;
                            border-radius: 0;
                        }
                    </style>
                    <style>
                             
.card_1{
    border-radius: 4px;
    background: #fff;
    box-shadow: 0 6px 10px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
      transition: .3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
  padding: 14px 80px 18px 36px;
  cursor: pointer;
  border:1px solid black;
  word-wrap: break-word;
}

.card_1:hover{
     transform: scale(1.05);
  box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
}

.card_1 h3{
  font-weight: 600;
}

.card_1 img{
  position: absolute;
  top: 20px;
  right: 15px;
  max-height: auto;
  
}

.card-1{
  background-image: url(https://ionicframework.com/img/getting-started/ionic-native-card.png);
      background-repeat: no-repeat;
    background-position: right;
    background-size: 80px;
    
}



@media(max-width: 990px){
  .card_1{
    margin: 20px;
    
  }
} 
</style>

                   

                    <?php 
                        $colorCardArr = 
                        ['info','cyan','success','orange','dark','danger'];
                        $getParsonalData = DB::select('SELECT * FROM parsonal_note WHERE is_deleted_status = "N" AND user_id = '.Session::get('sessionUserData')[0][0]->id.' ORDER BY id desc ');
                        if (!empty($getParsonalData)) {
                            $i=0;
                            foreach($getParsonalData as $parsonalNote) {
                                if ($i == 6) { $i=0; }
                    ?>
                                <div class="card" style="margin-top:10px;" >
                                    <div class="card_1 card-3 col-md-12 bg-<?php echo $colorCardArr[$i]; ?>">
                                        <div style="float:right;margin-right:-66px">
                                            <div class="tooltip10" style="border:none;">
                                                <a href="#" data-toggle="modal" data-target="#modal-default_admin_<?php echo $parsonalNote->id;?>" style="color:white;"><i class="ti-pencil-alt"></i></a>
                                                <span class="tooltiptext">Edit</span>
                                            </div>
                                            <div class="tooltip10" style="border:none;">
                                                <a href="#" onclick="deleteParsonalNote(<?php echo $parsonalNote->id; ?>)" 
                                                    style="color:white;"><i class="ti-trash"></i>
                                                </a>
                                                <span class="tooltiptext">Delete</span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex no-block align-items-center row">
                                                <div class="text-white col-md-12"><?php echo $parsonalNote->note;?></div>
                                                <div class="ml-auto">
                                                    <span class="text-white display-6"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                &nbsp;
                                
                                <div class="modal fade in" data-backdrop="static" data-keyboard="false" 
                                    id="modal-default_admin_<?php echo $parsonalNote->id;?>" style="padding-right: 17px;">
                                    <div class="modal-dialog" style="max-width: 629px;">
                                        <form class="form-horizontal" id="register-form" action="{{route('parsonalcard.edit')}}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="parsonalId" id="parsonalId"  value="<?php echo $parsonalNote->id;?>">
                                            <div class="modal-content" style="border-radius:13px">
                                                <style>
                                                    .modal-headers {
                                                        align-items: flex-start;
                                                        justify-content: space-between;
                                                        padding: 1rem;
                                                        border-bottom: 1px solid rgba(0,0,0,.1);
                                                        border-top-left-radius: 2px;
                                                        border-top-right-radius: 2px;
                                                    }
                                                    .modal-footers {
                                                        align-items: center;
                                                        justify-content: flex-end;
                                                        padding: 1rem;
                                                        border-top: 1px solid rgba(0,0,0,.1);
                                                        border-bottom-right-radius: 2px;
                                                        border-bottom-left-radius: 2px;
                                                    }
                                                </style>
                                                
                                                <div class="modal-headers">
                                                    <button type="button" class="close" data-dismiss="modal"aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <h4 class="modal-title">Edit Personal Note</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="box-body pad">
                                                        <textarea id="editor_<?php echo $parsonalNote->id; ?>" 
                                                            name="editor"  rows="10" cols="80"><?php echo $parsonalNote->note; ?></textarea>
                                                        <div id="paymentFormErr"></div>
                                                        <span class="text-danger" id="noteMsg_<?php echo $parsonalNote->id; ?>"></span>
                                                    </div>
                                                </div>
                                                <div class="modal-footers">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <button type="submit"  class="btn btn-success">Submit</button>
                                                                </div>
                                                                <div class="col-md-8"></div>
                                                                <div class="col-md-2">
                                                                    <button type="button"  data-dismiss="modal" aria-hidden="true"  
                                                                        class="btn waves-effect waves-light btn-dark">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> 
                                <?php
                                $i++;
                            }
                        }
                    ?>
            
              
                
                
                <a href="#"  class="float_7854" data-toggle="modal" data-target="#modal-default_admin">
                    <i class="fa fa-plus my-float_7854" style="margin-top:24px;"></i>
                </a>
                
                <div class="modal fade in" data-backdrop="static" data-keyboard="false" id="modal-default_admin" 
                    style="padding-right: 17px;">
                    <div class="modal-dialog" style="max-width: 629px;" >
                        <div class="modal-content" style="border-radius:13px">
                            <style>
                                .modal-headers {
                                    align-items: flex-start;
                                    justify-content: space-between;
                                    padding: 1rem;
                                    border-bottom: 1px solid rgba(0,0,0,.1);
                                    border-top-left-radius: 2px;
                                    border-top-right-radius: 2px;
                                }
                                
                                .modal-footers {
                                    align-items: center;
                                    justify-content: flex-end;
                                    padding: 1rem;
                                    border-top: 1px solid rgba(0,0,0,.1);
                                    border-bottom-right-radius: 2px;
                                    border-bottom-left-radius: 2px;
                                }
                            </style>
                            <div class="modal-headers">
                                <button type="button" class="close" data-dismiss="modal"aria-label="Close" 
                                    onclick="closeParsonalNotes()">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Add Personal Note</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box-body pad">
                                    <textarea id="editor" name="editor"  rows="10" cols="80"></textarea>
                                    <div id="paymentFormErr"></div>
                                    <span class="text-danger" id="noteMsg"></span>
                                </div>
                            </div>
                            <div class="modal-footers">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <button type="submit" 
                                                    onclick="addParsonalNotes()"             id="addParsonalNot" 
                                                    class="btn btn-success"                 >Submit</button>
                                            </div>
                                            <div class="col-md-8"></div>
                                            <div class="col-md-2">
                                                <button type="button" 
                                                    data-dismiss="modal" 
                                                    aria-hidden="true" 
                                                onclick="closeParsonalNotes()" class="btn waves-effect waves-light btn-dark">Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
/*    function resetAttendanceForm() {
        window.location.href="{{ route('attendance') }}";
    }*/
</script>
    @include('admin.common.script2')
    <script src="{{ URL::asset('public/admin/ajax/libs/angularjs/1.5.6/angular.min.js')}}"></script>
    <script src="{{ URL::asset('public/admin/angular-datatables-0.6.2/dist/angular-datatables.min.js')}}"></script>   
    
    <script type="text/javascript">
        var app = angular.module("myApp", ['datatables']);
        app.controller("mainCtrl", function($scope,$http) {
            
            $scope.attendanceFormData = {};
            $scope.fetchAttendanceData = function() {
                $http.get("{{route('angularAttendance.view')}}").success(function(data) {
                    $scope.attendanceData = data;
                });
            };
        });
        
        function closeParsonalNotes()
        {   
            $('#noteMsg').hide();        
        }
        
        function deleteParsonalNote(noteId) 
        {
            $.ajax({
                type: "GET",
                url: '{{route("parsonalcard.remove")}}',
                data : {  
                    noteId: noteId,
                },
                success: function(data) {
                    window.location.href = "{{route('parsonalcard') }}";
                }
            });
        }
        
        function addParsonalNotes()
        {
            var note = CKEDITOR.instances.editor.getData();
            if (note=='' || note==null) {
                $('#noteMsg').show();
                $('#noteMsg').html("Please add Parsonal Note");
            } else {
                $('#noteMsg').hide();
                $.ajax({
                    type : "GET",
                    url  : '{{route("parsonalcard.add")}}',
                    data : {  
                        note: note,
                    },
                    success: function(data) {
                        window.location.href = "{{route('parsonalcard') }}";
                    }
                });
            }
        }
    </script>
    </body>
</html>

