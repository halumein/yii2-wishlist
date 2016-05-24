$(function () {

    var wishlist = {
            addElement: function (model, itemId, url, button) {
                $.post({
                    url: url,
                    data: { model: model, itemId: itemId},
                    beforeSend: function () {
                        $(button).data('action', 'wait').attr('data-action', 'wait');
                    },
                    success: function (response) {
                        if (response) {
                            $(button).data('action', 'remove').attr('data-action', 'remove');
                            $(button).data('url', response.url).attr('data-url', response.url);
                            $(button).addClass('in-list');
                            $(button).text('В желаемом');
                            return true;
                        } else {
                            $(button).data('action', 'add').attr('data-action', 'add');
                            return false;
                        }
                    }
                })
                .fail(function(response) {
                    $(button).data('action', 'add').attr('data-action', 'add');
                    return false;
                });
            },
            removeElement: function (model, itemId, url, button) {
                $.post({
                    url: url,
                    data: { model: model, itemId: itemId},
                    beforeSend: function () {
                        $(button).data('action', 'wait').attr('data-action', 'wait');
                    },
                    success: function (response) {
                        if (response) {
                            $(button).data('action', 'add').attr('data-action', 'add');
                            $(button).data('url', response.url).attr('data-url', response.url);
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
            action = $(self).data('action'),
            url = $(self).data('url');

        if (action === 'add') {
            wishlist.addElement(model, itemId, url, self);
        } else if (action === 'remove') {
            wishlist.removeElement(model, itemId, url, self);
        }
    });

});
