export default function() {

    $(function() {
        $('.j-vacation-add').click(function() {
            let $t = $(this),
                $vacation = $t.closest('.j-vacation');

            vacationAction.call(this, $vacation, {
                data: $vacation.serialize(),
                url: $t.data('action'),
                method: 'POST',
            })
        });

        $('.j-vacation-update').click(function() {
            let $t = $(this),
                $vacation = $t.closest('.j-vacation');

            vacationAction.call(this, $vacation, {
                data: $vacation.serialize(),
                url: $t.data('action'),
                method: 'PUT',
            })
        });

        $('.j-vacation-delete').click(function() {
            let $t = $(this),
                $vacation = $t.closest('.j-vacation');

            let data = {
                _token: $vacation.find('[name="_token"]').val()
            };

            vacationAction.call(this, $vacation, {
                data: data,
                method: 'DELETE',
                url: $t.data('action')
            })
        });

        $('.j-vacation-fix').click(function() {
            let $t = $(this),
                $vacation = $t.closest('.j-vacation');
            let data = {
                fix: 1,
                _token: $vacation.find('[name="_token"]').val(),
            };

            vacationAction.call(this, $vacation, {
                data: data,
                method: 'PATCH', url: $t.data('action')
            })
        });


        function vacationAction($block, options) {
            if ($block.hasClass('processing')) {
                return;
            }

            $block.find('input').attr('readonly', true);
            $block.addClass('processing');

            $.ajax({
                url: $block.attr('action'),
                method: $block.attr('method'),
                dataType: 'json',
                ...options
            }).done(function(r) {
                $block.removeClass('processing');
                $block.find('input').attr('readonly', false);
                if (!r.success) {
                    alert('Операцию произвести НЕ удалось. '+r.error);
                    return;
                }
                window.location.href = '/vacation';

            }).fail(function(r) {
                let response = JSON.parse(r.responseText);
                alert('Операцию произвести НЕ удалось.' + "\n" + response.message);
                $block.removeClass('processing');
                $block.find('input').attr('readonly', false);
            });
        }
    });
}

