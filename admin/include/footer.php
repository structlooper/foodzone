 <script src="<?php echo ASSETSPATH; ?>js/lib/jquery.min.js"></script><!-- jquery vendor -->
 <script src="<?php echo ASSETSPATH; ?>js/lib/jquery.nanoscroller.min.js"></script><!-- nano scroller -->
 <script src="<?php echo ASSETSPATH; ?>js/lib/sidebar.js"></script><!-- sidebar -->
 <!--<script src="<?php echo ASSETSPATH; ?>js/lib/bootstrap.min.js"></script>-->
 <!-- bootstrap -->
 <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/lib/mmc-common.js"></script>


 <script src="<?php echo ASSETSPATH; ?>js/lib/owl-carousel/owl.carousel.min.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/scripts.js"></script><!-- scripit init-->
 <script src="<?php echo ASSETSPATH; ?>js/lib/data-table/datatables.min.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/lib/data-table/dataTables.buttons.min.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/lib/data-table/buttons.flash.min.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/lib/data-table/jszip.min.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/lib/data-table/pdfmake.min.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/lib/data-table/vfs_fonts.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/lib/data-table/buttons.html5.min.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/lib/data-table/buttons.print.min.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/lib/data-table/datatables-init.js"></script>
 <script src="<?php echo ASSETSPATH; ?>js/lib/sweetalert/sweetalert.min.js"></script>
 <script type="text/javascript" src="<?php echo ASSETSPATH; ?>js/1.9.jquery.validate.js"></script>
 
 <script type="text/javascript">
    function customAlertBox(title,text,type, showCancelButton, confirmButtonClass, confirmButtonText){
        if(showCancelButton=="false"){
            showCancelButton=false;
        }else {
            showCancelButton=true;
        }
        //alert(showCancelButton)
        swal({
            title: title,
            text: text,
            type: type,
            showCancelButton: showCancelButton,
            confirmButtonClass: confirmButtonClass,
            confirmButtonText: "<?=$this->lang->line('ok')?>",
            cancelButtonText: "<?=$this->lang->line('cancel')?>"
        });
        
    }

    function delete_status(url, id, value=false){
        customAlertBox("", "<?=$this->lang->line('delete_alert')?>", "error", "true", "btn-danger", "");
        $('.sweet-alert').find('.confirm').click(function(e){
            $.ajax({
                type:"POST",
                url:url,
                data:{'id':id, 'value':value},
                success: function(data) {
                    window.location.reload();
                }
            });          
            
        })
        
    }

    function multiple_delete(url) {
        var checkValues = $('input[name=checked_id]:checked').map(function(){
                return $(this).val();
        }).get();
        
        customAlertBox("", "<?=$this->lang->line('multiple_delete_alert')?>", "error", "true", "btn-danger", "");
        $('.sweet-alert').find('.confirm').click(function(e){
            $.ajax({
                type:"POST",
                url:url,
                data:{'id':checkValues},
                success: function(data) {
                    window.location.reload();
                }
            });          
            
        })
    }

    $(document).on('click', '#select_all', function() {
        if (this.checked) {
            $('.checkbox').each(function() {
                this.checked = true;
                $('#postme').removeAttr('disabled');
            });
        } else {
            $('.checkbox').each(function() {
                this.checked = false;
                $('#postme').attr('disabled', 'disabled');
            });
        }
    });

    $(document).on('click', '.checkbox', function() {
        $('#postme').prop('disabled', !$('.checkbox:checked').length);
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            $('#select_all').prop('checked', true);
        } else {
            $('#select_all').prop('checked', false);
        }
    });

    $('#bootstrap-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
		"language": {
            "lengthMenu": "<?=$this->lang->line('display')?> _MENU_ <?=$this->lang->line('records_per_page')?>",
            "zeroRecords": "<?=$this->lang->line('no_data_available')?>",
            "info": "<?=$this->lang->line('showing_page')?> _PAGE_ <?=$this->lang->line('of')?> _PAGES_",
            "infoEmpty": "<?=$this->lang->line('no_records_available')?>",
            "infoFiltered": "(<?=$this->lang->line('filtered_from')?> _MAX_ <?=$this->lang->line('total_entries')?>)",
            "paginate": {
                "previous": "<?=$this->lang->line('previous')?>",
                "next": "<?=$this->lang->line('next')?>"
            }
        }
    });



    $('#bootstrap-data-table-export').DataTable({
        dom: 'lBfrtip',
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: [
            'excel', 'pdf', 'print'
		],
		"language": {
            "lengthMenu": "<?=$this->lang->line('display')?> _MENU_ <?=$this->lang->line('records_per_page')?>",
            "zeroRecords": "<?=$this->lang->line('no_data_available')?>",
            "info": "<?=$this->lang->line('showing_page')?> _PAGE_ <?=$this->lang->line('of')?> _PAGES_",
            "infoEmpty": "<?=$this->lang->line('no_records_available')?>",
            "infoFiltered": "(<?=$this->lang->line('filtered_from')?> _MAX_ <?=$this->lang->line('total_entries')?>)",
            "paginate": {
                "previous": "<?=$this->lang->line('previous')?>",
                "next": "<?=$this->lang->line('next')?>"
            }
        }
    });

 </script>