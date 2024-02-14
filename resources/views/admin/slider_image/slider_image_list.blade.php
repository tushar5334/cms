@extends('admin.common.layout')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Slider Image Management</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.get.dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Slider Images</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title float-none float-sm-left mb-3">Slider Images List</h3>
          <a href="{{ route('admin.slider-images.create') }}">
            <div class="btn btn-primary float-sm-right">
              <i class="fas fa-plus fa-lg mr-2"></i>
              Add Slider Image
            </div>
          </a>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-sm-2">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" name="start_date" class="form-control float-right datepicker" id="start_date"
                    placeholder="Select Start Date" value="" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" name="end_date" class="form-control float-right datepicker" id="end_date"
                    placeholder="Select End Date" value="" autocomplete="off">
                </div>
                <span class="text-danger endDateError">

                </span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-2">
              <div class="form-group">
                <div class="input-group">
                  <button type="button" class="deleteMultiple btn btn btn-danger"><span><i
                        class="fas fa-trash"></i></span> Delete
                    All</button>
                </div>
              </div>
            </div>
            <div class="col-2">
              <div class="form-group">
                <div class="input-group">
                  <button type="button" class="activeMultiple btn btn-success"><span><i
                        class="fas fa-check-circle"></i></span>
                    Active
                  </button>
                </div>
              </div>
            </div>
            <div class="col-2">
              <div class="form-group">
                <div class="input-group">
                  <button type="button" class="deactiveMultiple btn btn-secondary"><span><i
                        class="fas fa-ban"></i></span>
                    Deactive</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">

          <div class="table-overflow">
            <table id="slider_image_datatable" class="table table-bordered table-striped display responsive"
              style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>#</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>

              </tfoot>
            </table>
          </div>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

<script>
  $(function () {
     $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayHighlight: true,
      });
      var startDate = "";
      var endDate = "";
      var dataTable = $('#slider_image_datatable').DataTable({
          processing: false,
          serverSide: true,          
          info: true,
          lengthChange: true,
          responsive: true,
          searching: true,
          language: {
            emptyTable: "No Page Found"
          },
          ajax: {
              url: "{{ route('admin.slider-images.index') }}",
              data: function(data){
               data.startDate = startDate;
               data.endDate = endDate;
              }
          },
          order:[[4, "desc" ]],
          //dom: 'lBfrtip',
          buttons: [
             /*  {
                  text: '<i class="fas fa-trash"></i> Delete All',
                  className: 'deleteMultiple btn btn-danger'
              },
              {
                  text: '<i class="fas fa-check-circle"></i> Active',
                  className: 'activeMultiple btn btn-success'
              },
              {
                  text: '<i class="fas fa-ban"></i> Deactive',
                  className: 'deactiveMultiple btn btn-secondary'
              }, */
          ],
          columns: [
            {
              targets: 0,
              data: 'slider_id',
              className: 'select-checkbox',
              checkboxes: {
                selectRow: true,
              }
            }, 
             {
              sTitle: "#",
              data: "slider_id",
              name: "slider_id",
              orderable: false,
              render: function(data, type, row, meta) {                  
                  var pageinfo = dataTable.page.info();
                  var currentpage = (pageinfo.page) * pageinfo.length;
                  var display_number = (meta.row + 1) + currentpage;
                  return display_number;
              }
            },
            {
              sTitle: "Title",
              data: "title", 
              name: "title",
              orderable: true,
              searchable: true,
              render: function(data, type, row, meta) {                                    
                var str = "";
                if(data){
                  str +=  data;                
                }                               
                return str;

              }
            },
            {
              sTitle: "Description",
              data: "description", 
              name: "description",
              orderable: true,
              searchable: true,
              render: function(data, type, row, meta) {
                var Char = 20;                                    
                var str = "";
               if(data){
                if(data.length > Char) {

                  var SmallText= data.substring(0,Char);
                  var cleanStr= data.replace(/["']/g, "");
                  str +=  '<div id="showrequest_'+row.slider_id+'">';
                  str +=  '<a class="font-weight-light" title="'+cleanStr+'"> '+SmallText + '</a>';
                  str +=  "<a id=\"toggleButton\" class='text-primary btn-sm toggleButton' data-id="+row.slider_id+" data-content="+cleanStr+" href=\"javascript:void(0);\">... more</a>";
                  str +=  '</div>';

                  str +=  '<div id="hiderequest_'+row.slider_id+'" style="display:none">';
                  str +=  '<a style="word-break:break-all" class="font-weight-light" title="'+cleanStr+'"> '+cleanStr + '</a>';
                  str +=  "<a id=\"toggleButton\" class='text-primary btn-sm toggleButton' data-id="+row.slider_id+" data-content="+cleanStr+" href=\"javascript:void(0);\">less</a>";
                  str +=  '</div>';

                } else {
                  str +=  data;
                }                        
              } else {
                str += 'N/A';
              }                              
                return str;

              }
            },
            {
              sTitle: "created At",
              data: "created_at", 
              name: "created_at",
              orderable: true,
              searchable: false,
              render: function(data, type, row, meta) {                                    
                var str = "";
                if(data){
                  str +=  data;                
                }                               
                return str;
              }
            },
            {
              sTitle: "Action",
              data: "action",
              name: "action",
              orderable: false,
              searchable: false,
              render: function(data, type, row, meta) { 
                var edit_url = '{{ route("admin.slider-images.edit", ":slider_id") }}';
                edit_url = edit_url.replace(':slider_id', row.slider_id);
                var str = "";
                str += '<div class="btn-group">';
                 if(row.status == 1){
                  str += '<a title="Status" id="'+row.slider_id+'" class="btn btn-success status_active" href="javascript:;" data-id="'+row.slider_id+'"><i class="fas fa-check-circle"></i></a>';
                }else{
                  str += '<a title="Status" id="'+row.slider_id+'" class="btn btn-default status_active" href="javascript:;" data-id="'+row.slider_id+'"><i class="fas fa-ban"></i></a>';
                }
                str+= '<a title="Edit" id="'+row.slider_id+'" class="btn btn-warning edit_icon icon user-edit" href="'+edit_url+'"><i class="fas fa-edit"></i></a>';
                str += '<a title="Delete" id="'+row.slider_id+'" class="btn btn-danger delete_icon icon delete_record" data-tooltip="Delete" href="javascript:;" data-id="'+row.slider_id+'" data-toggle="modal" data-target="#modal-sm-'+row.slider_id+'"><i class="fas fa-trash"></i></a>'
                str += '</div>';
                return str;
              }
            }
          ],
          select: {
            style: 'multi'
          },
          fnRowCallback: function( nRow, aData, iDisplayIndex ) {           
            return nRow;
          },
          fnDrawCallback: function( oSettings ) {
            // Delete Record
            $('#slider_image_datatable tbody').on( 'click', 'tr td .status_active', function (e) {
            let statusId = $(this).attr("data-id");
            let url = "{{ route('admin.post.slider-images.change-status') }}";
            self.confirmStatus(statusId, url, dataTable);
            });
            $('#slider_image_datatable tbody').on( 'click', 'tr td .delete_record', function (e) {
            let deletedId = $(this).attr("data-id");
            let url = '{{ route("admin.slider-images.destroy", ":slider_id") }}';
            url = url.replace(':slider_id', deletedId);
            self.confirmDelete(deletedId, url, dataTable);
            });
            $('a.toggleButton').on( 'click', function (e) {
            let reqId = this.dataset.id;
            let content = this.dataset.content;
            $('#showrequest_'+reqId).toggle();
            $('#hiderequest_'+reqId).toggle();
            });
            
            $('a.responseToggle').on( 'click', function (e) {
            let reqId = this.dataset.id;
            let content = this.dataset.content;
            $('#responseShowRequest_'+reqId).toggle();
            $('#responseHideRequest_'+reqId).toggle();
            });
          },
           fnInitComplete: function(oSettings, json) {
            $('.deleteMultiple').on('click',function(e){
              let selectedIds = dataTable.columns().checkboxes.selected()[0];
              if(selectedIds.length > 0)
              {
                let deletedIds = selectedIds;
                selectedIds = [];
                let url = "{{ route('admin.post.slider-images.multiple-delete') }}";
                self.confirmMultipleDelete(deletedIds, url, dataTable);
              }else{
                notification('error', "Please Select CheckBox First"); 
              }
                dataTable.columns().checkboxes.deselect(true);
            });
            $('.activeMultiple').on('click',function(){
              let selectedIds = dataTable.columns().checkboxes.selected()[0];
              if(selectedIds.length > 0)
              {
                let activeIds = selectedIds;
                selectedIds = [];
                let url = "{{ route('admin.post.slider-images.multiple-change-status') }}";
                self.confirmMultipleStatusChange(activeIds, url, dataTable, "active"); 
                dataTable.columns().checkboxes.deselect(true);
            
              }else{
                notification('error', "Please Select CheckBox First"); 
              }
            });
            $('.deactiveMultiple').on('click',function(){
              let selectedIds = dataTable.columns().checkboxes.selected()[0];
              if(selectedIds.length >= 1)
              {
                let inActiveIds = selectedIds;
                selectedIds = [];
                let url = "{{ route('admin.post.slider-images.multiple-change-status') }}";
                self.confirmMultipleStatusChange(inActiveIds, url, dataTable, "inactive");
                dataTable.columns().checkboxes.deselect(true);
              }else{
                notification('error', "Please Select CheckBox First"); 
              }
            });
          },
          createdRow: function( row, data, dataIndex ) {
            // Set the data-status attribute, and add a class
            /* $( row ).find('td:eq(0)')
            .attr('data-title');
            $( row ).find('td:eq(1)')
            .attr('data-title', '#');
            $( row ).find('td:eq(2)')
            .attr('data-title', 'Title');
            $( row ).find('td:eq(3)')
            .attr('data-title', 'Meta Title');
            $( row ).find('td:eq(4)')
            .attr('data-title', 'Meta Keywords');
            $( row ).find('td:eq(5)')
            .attr('data-title', 'Description');
            $( row ).find('td:eq(6)')
            .attr('data-title', 'Name');
            $( row ).find('td:eq(7)')
            .attr('data-title', 'Page Slug');
            $( row ).find('td:eq(8)')
            .attr('data-title', 'Page Type');
            $( row ).find('td:eq(9)')
            .attr('data-title', 'Created At');
            $( row ).find('td:eq(10)')
            .attr('data-title', 'Action'); */
          }
    });
    $('#start_date').on('change',function(){
        startDate = $(this).val();
        start_date = moment($('#start_date').val(),'DD/MM/YYYY').format('YYYY-MM-DD');
        end_date = moment($('#end_date').val(),'DD/MM/YYYY').format('YYYY-MM-DD');
        if($('#end_date').val() != ""){
          console.log(moment(new Date(start_date)).isAfter(new Date(end_date)));
          if(moment(new Date(start_date)).isAfter(new Date(end_date)) == true){
            $( ".endDateError" ).append( '<i class="fa fa-times-circle-o"></i> End date should be greater than start date' );
            return false;
          }else{
            $( ".endDateError" ).html('');
          }
        }
        
        dataTable.draw();
       
    });
    $('#end_date').on('change',function(){
        endDate = $(this).val();
       start_date = moment($('#start_date').val(),'DD/MM/YYYY').format('YYYY-MM-DD');
        end_date = moment($('#end_date').val(),'DD/MM/YYYY').format('YYYY-MM-DD');
        if($('#start_date').val() != ""){
          console.log(moment(new Date(start_date)).isAfter(new Date(end_date)));
          if(moment(new Date(start_date)).isAfter(new Date(end_date)) == true){
            $( ".endDateError" ).append( '<i class="fa fa-times-circle-o"></i> End date should be greater than start date' );
             return false;
          }else{
            $( ".endDateError" ).html('');
          }
        }
        dataTable.draw();
    });
  });
</script>

@stop