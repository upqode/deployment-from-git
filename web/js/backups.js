;(function($, window, document) {
    "use strict";

    $(document).ready(function() {
        var restoreLastBackup = function() {
            $('.ajax-backup-restore-last').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                swal({
                        title: 'Вы уверены?',
                        text: 'Выполнение данного действия произведет к удалению текущей версии сайта и восстановит последнюю версию бекапа!',
                        type: 'warning',
                        closeOnConfirm: false,
                        showCancelButton: true,
                        showLoaderOnConfirm: true
                    },
                    function() {
                        $.ajax({
                            url: '/backup/restore-last',
                            method: 'POST',
                            data: {id: id},
                            dataType: 'json',
                            success: function(response) {
                                swal({title: response['message'], type: response['type']});
                            }
                        });
                    });
            });
        };

        var restoreBackup = function() {
            $('.ajax-backup-restore').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                swal({
                        title: 'Вы уверены?',
                        text: 'Выполнение данного действия произведет к удалению текущей версии сайта и восстановит версию из бекапа!',
                        type: 'warning',
                        closeOnConfirm: false,
                        showCancelButton: true,
                        showLoaderOnConfirm: true
                    },
                    function() {
                        $.ajax({
                            url: '/backup/restore',
                            method: 'POST',
                            data: {id: id},
                            dataType: 'json',
                            success: function(response) {
                                swal({title: response['message'], type: response['type']});
                            }
                        });
                    });
            });
        };

        var deleteBackup = function() {
            $('.ajax-backup-delete').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                swal({
                    title: 'Вы уверены?',
                    text: 'Выполнение данного действия произведет к удалению бекапа!',
                    type: 'warning',
                    closeOnConfirm: false,
                    showCancelButton: true,
                    showLoaderOnConfirm: true
                },
                function() {
                    $.ajax({
                        url: '/backup/delete',
                        method: 'POST',
                        data: {id: id},
                        dataType: 'json',
                        success: function(response) {
                            if (response['type'] == 'success') {
                                $('.ajax-row[data-id="'+ id +'"]').fadeOut('slow');
                            }

                            swal({title: response['message'], type: response['type']});
                        }
                    });
                });
            });
        };


        restoreLastBackup();
        restoreBackup();
        deleteBackup();
    });

})(jQuery, window, document);