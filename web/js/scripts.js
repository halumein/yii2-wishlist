$(function () {



    var wishlist = {
            addElement: function (model, itemId, button) {
                $.post({
                    url: '/wishlist/element/add',
                    data: { model: model, itemId: itemId},
                    beforeSend: function () {
                        $(button).data('action', 'wait').attr('data-action', 'wait');
                    },
                    success: function (response) {
                        if (response) {
                            $(button).data('action', 'remove').attr('data-action', 'remove');
                            $(button).addClass('in-list');
                            $(button).text('В желаемом');
                            return true;
                        } else {
                            $$(button).data('action', 'add').attr('data-action', 'add');
                            return false;
                        }
                    }
                })
                .fail(function(response) {
                    $(button).data('action', 'add').attr('data-action', 'add');
                    return false;
                });
            },
            removeElement: function (model, itemId, button) {
                $.post({
                    url: '/wishlist/element/remove',
                    data: { model: model, itemId: itemId},
                    beforeSend: function () {
                        $(button).data('action', 'wait').attr('data-action', 'wait');
                    },
                    success: function (response) {
                        if (response) {
                            $(button).data('action', 'add').attr('data-action', 'add');
                            $(button).removeClass('in-list');
                            $(button).text('В список желаемого');
                            return true;
                        } else {
                            $(button).data('action', 'remove').attr('data-action', 'remove');
                            return false;
                        }
                    }
                })
                .fail(function(response) {
                    $(button).data('action', 'remove').attr('data-action', 'remove');
                    return false;
                });
            },
        };

    $(document).on('click', '[data-role=hal_wishlist_button]',function () {
        var self = this,
            model = $(self).data('model'),
            itemId = $(self).data('item-id'),
            action = $(self).data('action');


        console.log();

        if (action === 'add') {
            wishlist.addElement(model, itemId, self);
        } else if (action === 'remove') {
            wishlist.removeElement(model, itemId, self);
        }
    });





});
