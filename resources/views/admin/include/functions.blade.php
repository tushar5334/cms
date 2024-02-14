{{-- AJAX Message --}}
<script>
    function confirmDelete(deleteId, deleteUrl, dataTable){ 
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: deleteUrl,
                    type: 'DELETE',
                    data: {
                        id:deleteId,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if(res && res.success) {
                            notification('success', res.message);                       
                        } else {
                            notification('error', res.message); 
                        }
                        dataTable.ajax.reload();                        
                    },
                    error: function(xhr) {
                        notification('error', res.message);
                    }
                }); 
            }
        });
    }
    function confirmStatus(statusId, statusURL, dataTable){ 
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change status of this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: statusURL,
                    type: 'POST',
                    data: {
                        id:statusId,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if(res && res.success) {
                            notification('success', res.message);                       
                        } else {
                            notification('error', res.message); 
                        }
                        dataTable.ajax.reload();                        
                    },
                    error: function(xhr) {
                        notification('error', res.message);
                    }
                }); 
            }
        });
    }
    function confirmMultipleDelete(deletedIds, deleteUrl, dataTable){ 
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete these records!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        ids:deletedIds,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if(res && res.success) {
                            notification('success', res.message);                       
                        } else {
                            notification('error', res.message); 
                        }
                        dataTable.ajax.reload();                        
                    },
                    error: function(xhr) {
                        notification('error', res.message);
                    }
                }); 
            }
        });
    }
    function confirmMultipleStatusChange(statusIds, activeUrl, dataTable, status){ 
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to "+status+" these records!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: activeUrl,
                    type: 'POST',
                    data: {
                        ids:statusIds,
                        status:status,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if(res && res.success) {
                            notification('success', res.message);                       
                        } else {
                            notification('error', res.message); 
                        }
                        dataTable.ajax.reload();                        
                    },
                    error: function(xhr) {
                        notification('error', res.message);
                    }
                }); 
            }
        });
    }

    function currentDateTime(attrName){
        setInterval(function() {         
            var cDateTime = moment().format("HH:mm:ss dddd DD MMM YYYY");            
            $(attrName).html(cDateTime);         
        }, 1000);
    }

    function sidebarDeviceData(attrEle){
        attrEle.toggleClass('active').siblings().removeClass('active');
        @if(isset($devicesList)){
            var devicesList = @json($devicesList);
            var id = attrEle.attr('id').split("_").pop()
            return devicesList.find(function(e) { return e.device_id == id; });
        }
        @endif
    } 

    function menuButClick() {
        setTimeout(function(){ 
            $('#menu_btn').trigger('click');
        }, 1500);
    }

    function setDaterange(id,parentEl,selectDate=""){
        var selectDateArr = selectDate.split('to');        
        // var startDate = moment().subtract('days', 29);
        var startDate = moment();
        var endDate = moment();
        if(selectDateArr.length > 1){
            startDate = selectDateArr[0];
            endDate = selectDateArr[1];
        }
        var picker = $('#'+id).daterangepicker({
            "parentEl": '#'+parentEl,
            "autoApply": true,
            locale: {
                format: 'YYYY-MM-DD',
                separator: "to"
            },
            "startDate": startDate,
            "endDate": endDate,
            // "minDate":moment().subtract(3, 'months').format("YYYY-MM-DD"),
            // "minDate":moment().subtract(3, 'months'),
            // "maxDate":moment().format("YYYY-MM-DD"),
            "maxDate":moment(),
        });
        return picker;
    }    
</script>