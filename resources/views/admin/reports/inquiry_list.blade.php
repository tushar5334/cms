@extends('admin.common.layout')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Inquiry Report</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.get.dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Inquiries</li>
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
          <h3 class="card-title float-none float-sm-left mb-3">Inquiry List</h3>
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
                  <button type="button" id="btn-show-all-children" class="btn btn btn-primary"><span><i
                        class="fas fa-plus-square"></i></span> Expand
                    All</button>
                </div>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <div class="input-group">
                  <button type="button" id="btn-hide-all-children" class="btn btn btn-primary"><span><i
                        class="fas fa-minus-square"></i></span> Collapse
                    All</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">

          <div class="table-overflow">
            <table id="inquiry_datatable" class="table table-bordered table-striped display responsive"
              style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th class="none"></th>
                  <th class="none"></th>
                  <th class="none"></th>
                  <th class="none"></th>
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
      var dataTable = $('#inquiry_datatable').DataTable({
          processing: false,
          serverSide: true,          
          info: true,
          lengthChange: true,
          responsive: true,
          searching: true,
          language: {
            emptyTable: "No Inquiry Found"
          },
          ajax: {
              url: "{{ route('admin.inquiries.index') }}",
              data: function(data){
               data.startDate = startDate;
               data.endDate = endDate;
              }
          },
          order:[[10, "desc" ]],
          //dom: 'lBfrtip',
          buttons: [
             /*  {
                  text: '<i class="fas fa-trash"></i> Delete All',
                  className: 'deleteMultiple btn btn-danger'
              }, */
          ],
          columns: [
            {
            targets: 0,
            data: 'inquiry_id',
            className: 'select-checkbox',
            checkboxes: {
            selectRow: true,
            }
            },
            {
              sTitle: "#",
              data: "inquiry_id",
              name: "inquiry_id",
              orderable: false,
              render: function(data, type, row, meta) {
              let pageinfo = dataTable.page.info();
              let currentpage = (pageinfo.page) * pageinfo.length;
              let display_number = (meta.row + 1) + currentpage;
              return display_number;
              }
            }, 
            {
            sTitle: "Name",
            data: "name",
            name: "name",
            orderable: true,
            searchable: true,
            render: function(data, type, row, meta) {
            let str = "";
            if(data){
            str += data;
            }
            return str;
            
            }
            },
            {
              sTitle: "Phone",
              data: "phone", 
              name: "phone",
             
              orderable: true,
              searchable: true,
              render: function(data, type, row, meta) {                                    
                let str = "";
                if(data){
                  str +=  data;                
                }                               
                return str;

              }
            },
            {
            sTitle: "Email",
            data: "email",
            name: "email",
            orderable: true,
            searchable: true,
            render: function(data, type, row, meta) {
            let str = "";
            if(data){
            str += data;
            }
            return str;
            }
            },
            {
            sTitle: "Product & End Use",
            data: "product_looking_for",
            name: "product_looking_for",
            orderable: true,
            searchable: true,
            render: function(data, type, row, meta) {
            let str = "";
            if(data){
            str += data;
            }
            return str;
            }
            },
            {
            sTitle: "Company Name",
            data: "company_name",
            name: "company_name",
            orderable: true,
            searchable: true,
            render: function(data, type, row, meta) {
            let str = "";
            if(data){
            str += data;
            }
            return str;
            }
            },
            {
            sTitle: "Company Address",
            data: "company_address",
            name: "company_address",
            orderable: true,
            searchable: true,
            render: function(data, type, row, meta) {
            let str = "";
            if(data){
            str += data;
            }
            return str;
            }
            },
            {
            sTitle: "End Use Application",
            data: "end_use_application",
            name: "end_use_application",
            orderable: true,
            searchable: true,
            render: function(data, type, row, meta) {
            let str = "";
            if(data){
            str += data;
            }
            return str;
            }
            },
            {
              sTitle: "Remark",
              data: "additional_remark", 
              name: "additional_remark",
              orderable: true,
              searchable: true,
              render: function(data, type, row, meta) {
                let str = "";
                if(data){
                str += data;
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
                var str = "";
                str += '<div class="btn-group">';
                str += '<a title="Delete" id="'+row.inquiry_id+'" class="btn btn-danger delete_icon delete_record" data-tooltip="Delete" href="javascript:;" data-id="'+row.inquiry_id+'" data-toggle="modal" data-target="#modal-sm-'+row.inquiry_id+'"><i class="fas fa-trash"></i></a>'
                str += '</div>';
                return str;
              }
            }
          ],
          select: {
            style: 'multi',
          },
          fnRowCallback: function( nRow, aData, iDisplayIndex ) {      
            return nRow;
          },
          fnDrawCallback: function( oSettings ) {
            // Delete Record
            $('#inquiry_datatable tbody').on( 'click', 'tr td .delete_record', function (e) {       
            let deletedId = $(this).attr("data-id");
            let url = '{{ route("admin.inquiries.destroy", ":inquiry_id") }}';
            url = url.replace(':inquiry_id', deletedId);
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
                let url = "{{ route('admin.post.inquiries.multiple-delete') }}";
                self.confirmMultipleDelete(deletedIds, url, dataTable);
              }else{
                notification('error', "Please Select CheckBox First"); 
              }
                dataTable.columns().checkboxes.deselect(true);
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

    // Handle click on "Expand All" button
    $('#btn-show-all-children').on('click', function(){
    // Expand row details
    dataTable.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
    });
    
    // Handle click on "Collapse All" button
    $('#btn-hide-all-children').on('click', function(){
    // Collapse row details
    dataTable.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
    });
  });
</script>

@stop