@extends('admin.common.layout')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">User Management</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.get.dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Users</li>
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
          <h3 class="card-title float-none float-sm-left mb-3">User List</h3>
          <a href="{{ route('admin.users.create') }}">
            <div class="btn btn-primary float-sm-right">
              <i class="fas fa-plus fa-lg mr-2"></i>
              Add User
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
            <div class="col-sm-2">
              <div class="form-group">
                <div class="input-group">
                  <button type="button" class="deleteMultiple btn btn btn-danger"><span><i
                        class="fas fa-trash"></i></span> Delete
                    All</button>
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <div class="input-group">
                  <button type="button" class="activeMultiple btn btn-success"><span><i
                        class="fas fa-check-circle"></i></span> Active
                  </button>
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <div class="input-group">
                  <button type="button" class="deactiveMultiple btn btn-secondary"><span><i
                        class="fas fa-ban"></i></span> Deactive</button>
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <div class="input-group">
                  <button type="button" class="exportUser btn btn-success"><span><i class="fas fa-download"></i></span>
                    Export
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">

          <div class="table-overflow">
            <table id="user_datatable" class="table table-bordered table-striped display responsive" style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
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
     /*  $(".alert").delay(4000).slideUp(200, function() {
          $(this).alert('close');
      }); */
      var startDate = "";
      var endDate = "";
      var dataTable = $('#user_datatable').DataTable({
          processing: false,
          serverSide: true,          
          info: true,
          lengthChange: true,
          responsive: true,
          searching: true,
          language: {
            emptyTable: "No User Found"
          },
          ajax: {
              url: "{{ route('admin.users.index') }}",
              data: function(data){
               data.startDate = startDate;
               data.endDate = endDate;
              }
          },
          order:[[4, "desc" ]],
          //dom: 'lBfrtip',
          buttons: [
              /* {
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
              },
              {
                  text: '<i class="fas fa-download"></i> Export',
                  className: 'exportUser btn btn-success'
              }, */
          ],
          columns: [
            {
              targets: 0,
              data: 'user_id',
              className: 'select-checkbox',
              checkboxes: {
                selectRow: true,
              }
          }, 
            {
              sTitle: "#",
              data: "user_id",
              name: "user_id",
              orderable: false,
              render: function(data, type, row, meta) {
                  var pageinfo = dataTable.page.info();
                  var currentpage = (pageinfo.page) * pageinfo.length;
                  var display_number = (meta.row + 1) + currentpage;
                  return display_number;
              }
            },
            {
              sTitle: "Name",
              data: "name", 
              name: "name",
              orderable: true,
              searchable: true
            },
            {
              sTitle: "Email",
              data: "email", 
              name: "email",
              orderable: true,
              searchable: true
            },
            {
              sTitle: "Created At",
              data: "created_at", 
              name: "created_at",
              orderable: true,
              searchable: false
            },
            {
              sTitle: "Action",
              data: "action",
              name: "action",
              orderable: false,
              searchable: false,
              render: function(data, type, row, meta) { 
                var edit_url = '{{ route("admin.users.edit", ":user_id") }}';
                edit_url = edit_url.replace(':user_id', row.user_id);
                var str = "";
                str += '<div class="btn-group">';
                 if(row.status == 1){
                  str += '<a title="Status" id="'+row.user_id+'" class="btn btn-success status_active" href="javascript:;" data-id="'+row.user_id+'"><i class="fas fa-check-circle"></i></a>';
                }else{
                  str += '<a title="Status" id="'+row.user_id+'" class="btn btn-default status_active" href="javascript:;" data-id="'+row.user_id+'"><i class="fas fa-ban"></i></a>';
                }
                str+= '<a title="Edit" id="'+row.user_id+'" class="btn btn-warning edit_icon icon user-edit" href="'+edit_url+'"><i class="fas fa-edit"></i></a>';
                str += '<a title="Delete" id="'+row.user_id+'" class="btn btn-danger delete_icon icon delete_record" data-tooltip="Delete" href="javascript:;" data-id="'+row.user_id+'" data-toggle="modal" data-target="#modal-sm-'+row.user_id+'"><i class="fas fa-trash"></i></a>'
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
            $('#user_datatable tbody').on( 'click', 'tr td .status_active', function (e) {
              let statusId = $(this).attr("data-id");
              let url = "{{ route('admin.post.users.change-status') }}";
              self.confirmStatus(statusId, url, dataTable);                                                 
            });
            $('#user_datatable tbody').on( 'click', 'tr td .delete_record', function (e) {
              let deletedId = $(this).attr("data-id");
              let url = '{{ route("admin.users.destroy", ":user_id") }}';
              url = url.replace(':user_id', deletedId);
              self.confirmDelete(deletedId, url, dataTable);                                                 
            });
          },
          fnInitComplete: function(oSettings, json) {
            $('.deleteMultiple').on('click',function(e){
              let selectedIds = dataTable.columns().checkboxes.selected()[0];
              if(selectedIds.length > 0)
              {
                let deletedIds = selectedIds;
                selectedIds = [];
                let url = "{{ route('admin.post.users.multiple-delete') }}";
                self.confirmMultipleDelete(deletedIds, url, dataTable);
              }else{
                notification('error', "Please select checkbox first"); 
              }
                dataTable.columns().checkboxes.deselect(true);
            });
            $('.activeMultiple').on('click',function(){
              let selectedIds = dataTable.columns().checkboxes.selected()[0];
              if(selectedIds.length > 0)
              {
                let activeIds = selectedIds;
                selectedIds = [];
                let url = "{{ route('admin.post.users.multiple-change-status') }}";
                self.confirmMultipleStatusChange(activeIds, url, dataTable, "active"); 
                dataTable.columns().checkboxes.deselect(true);
            
              }else{
                notification('error', "Please select checkbox first"); 
              }
            });
            $('.deactiveMultiple').on('click',function(){
              let selectedIds = dataTable.columns().checkboxes.selected()[0];
              if(selectedIds.length >= 1)
              {
                let inActiveIds = selectedIds;
                selectedIds = [];
                let url = "{{ route('admin.post.users.multiple-change-status') }}";
                self.confirmMultipleStatusChange(inActiveIds, url, dataTable, "inactive");
                dataTable.columns().checkboxes.deselect(true);
              }else{
                notification('error', "Please select checkBox first"); 
              }
            });
            $('.exportUser').on('click',function(){
              var searchData = $('.dataTables_filter input').val();
              var routName = "{{ route('admin.post.users.user-export') }}"; 
              var customeForm = $('<form action="'+routName+'" method="POST"></form>').appendTo('body');
              customeForm.append('<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}"/>');
              customeForm.append('<input type="hidden" name="searchData" id="searchData" value="'+searchData+'"/>');
              customeForm.append('<input type="hidden" name="startDate" id="startDate" value="'+startDate+'"/>');
              customeForm.append('<input type="hidden" name="endDate" id="endDate" value="'+endDate+'"/>');
              customeForm.submit();
            });
             $('.select-checkbox').click(function(event) {  //on click 
            //var check_val = $('#user_datatable thead input[type="checkbox"]').prop('checked', this.checked);
            var check_val = $('#user_datatable thead input[type="checkbox"]:checked').length;
            
              dataTable.column(0).nodes().to$().each(function(index) {
                if (check_val == 1) {
                  $(this).find('#user_datatable tbody input[type="checkbox"]:checked').prop('checked', 'checked');
                } else {
                  $(this).find('#user_datatable tbody input[type="checkbox"]:checked').removeProp('checked');            
                }
              });    
              //dataTable.draw();
            });
          },
          createdRow: function( row, data, dataIndex ) {
            // Set the data-status attribute, and add a class
            /* $( row ).find('td:eq(0)')
            .attr('data-title');
            $( row ).find('td:eq(1)')
            .attr('data-title', '#');
            $( row ).find('td:eq(2)')
            .attr('data-title', 'Name');
            $( row ).find('td:eq(3)')
            .attr('data-title', 'Email');
            $( row ).find('td:eq(4)')
            .attr('data-title', 'Created At');
            $( row ).find('td:eq(5)')
            .attr('data-title', 'Action'); */
          }
    });
    $('#start_date').on('change',function(){
        startDate = $(this).val();
        start_date = moment($('#start_date').val(),'DD/MM/YYYY').format('YYYY-MM-DD');
        end_date = moment($('#end_date').val(),'DD/MM/YYYY').format('YYYY-MM-DD');
        if($('#end_date').val() != ""){
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