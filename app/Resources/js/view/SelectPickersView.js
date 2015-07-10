
var SelectPickersView = Backbone.View.extend({
    el: document,

    initialize: function() {
        this.$el.find('.selectpicker').selectpicker();
    }
});

module.exports = SelectPickersView;
