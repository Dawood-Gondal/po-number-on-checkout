/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_PoNumberOnCheckout
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

define([
        'ko',
        'jquery',
        'uiComponent',
        'mage/url'
    ], function (ko, $, Component, url) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'M2Commerce_PoNumberOnCheckout/checkout/poNumber'
            },

            /**
             *
             * @returns {*}
             */
            initObservable: function () {
                this.po = ko.observable();

                this.updatePo = function (data, event) {
                    var actionUrl = url.build('po_number/checkout/save');
                    $.ajax({
                        url: actionUrl,
                        data: {po_number: this.po},
                        type: "POST",
                        showLoader: true,
                        dataType: 'json'
                    }).done(function (data) {
                        console.log('success');
                    });
                }
                return this;
            }
        });
    }
);

