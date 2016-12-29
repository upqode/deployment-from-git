;(function($, window, document) {
    "use strict";

    $(document).ready(function() {
        // get repository name
        var getRepositoryName = function() {
            $('#repositoryform-remote_path').change(function() {
                $('#repositoryform-name').val($(this).find(':selected').text());
            });
        };

        // select local path
        var selectLocalPath = function() {
            // show modal
            $('#select-local-path-btn').click(function() {
                $('#select-local-path-modal').modal();
            });

            // select current dir as local path
            $('#select-current-dir').click(function() {
                var local_path = $('#local-path').val();

                $('#repositoryform-local_path').val(local_path);
                $('#select-local-path-modal').modal('hide');
            });

            // change dir
            $('body').on('click', '.change-dir', function(e) {
                e.preventDefault();

                var path = $('#local-path').val() + $(this).data('dir'),
                    dir_list_block = $('#dir-list-block'),
                    html = '';

                $.ajax({
                    url: '/repository/get-dir-info',
                    method: 'POST',
                    data: {dir: path},
                    dataType: 'html',
                    beforeSend: function() {
                        dir_list_block.find('.spinner').removeClass('hidden');
                        dir_list_block.find('.dir-list').empty();
                    },
                    success: function(response) {
                        response = JSON.parse(response);

                        response['dir_list'].forEach(function(el) {
                            html += '<li>';
                            html += '<a href="#" data-dir="/'+ el +'" class="change-dir">';
                            html += '<i class="mdi mdi-folder"></i> '+ el;
                            html += '</a>';
                            html += '</li>';
                        });

                        dir_list_block.find('.dir-list').html(html); // insert new directories in dom
                        $('#local-path').val(response['path']); // change hidden local path
                    },
                    complete: function() {
                        dir_list_block.find('.spinner').addClass('hidden');
                    }
                });
            });
        };

        // install commit
        var installCommit = function() {
            $('.install-commit-btn').click(function(e) {
                e.preventDefault();
                var this_btn = $(this);

                swal({
                    title: 'Вы уверены?',
                    text: 'Выполнение данного действия приведет к установки выбранной версии продукта.',
                    type: 'warning',
                    customClass: 'add-repository-modal-alert',
                    closeOnConfirm: false,
                    showCancelButton: true,
                    showLoaderOnConfirm: true
                },
                function() {
                    $.ajax({
                        url: '/repository/install-commit',
                        cache: false,
                        method: 'POST',
                        data: {
                            commit: this_btn.data('commit'),
                            repository_id: $('#repository-id').val()
                        },
                        dataType: 'json',
                        success: function(response) {
                            swal({title: response['result'], type: 'success'});
                        },
                        error: function(error) {
                            swal({title: error.responseText, type: 'error'});
                        }
                    });
                });
            });
        };




        installCommit();
        selectLocalPath();
        getRepositoryName();
    });

})(jQuery, window, document);