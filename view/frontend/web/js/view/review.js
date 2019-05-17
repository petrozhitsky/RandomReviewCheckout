define(
    [
        'jquery',
        'ko',
        'uiComponent'
    ],
    function(
        $,
        ko,
        Component
    ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Netzexpert_RandomReview/review'
            },

            initialize: function () {
                var self = this;
                this._super();
            }

        });
    }
);