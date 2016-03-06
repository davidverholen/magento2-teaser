/* global $, $H */

define([
    'mage/adminhtml/grid'
], function () {
    'use strict';

    return function (config) {
        var selectedTeaserItems = config.selectedTeaserItems,
            teaserGroupItems = $H(selectedTeaserItems),
            gridJsObject = window[config.gridJsObjectName],
            tabIndex = 1000;

        $('in_teaser_group_items').value = Object.toJSON(teaserGroupItems);

        /**
         * Register TeaserGroupItem
         *
         * @param {Object} grid
         * @param {Object} element
         * @param {Boolean} checked
         */
        function registerTeaserGroupItem(grid, element, checked) {
            if (checked) {
                if (element.positionElement) {
                    element.positionElement.disabled = false;
                    teaserGroupItems.set(element.value, element.positionElement.value);
                }
            } else {
                if (element.positionElement) {
                    element.positionElement.disabled = true;
                }
                teaserGroupItems.unset(element.value);
            }
            $('in_teaser_group_items').value = Object.toJSON(teaserGroupItems);
            grid.reloadParams = {
                'selected_products[]': teaserGroupItems.keys()
            };
        }

        /**
         * Click on item row
         *
         * @param {Object} grid
         * @param {String} event
         */
        function teaserGroupItemRowClick(grid, event) {
            var trElement = Event.findElement(event, 'tr'),
                isInput = Event.element(event).tagName === 'INPUT',
                checked = false,
                checkbox = null;

            if (trElement) {
                checkbox = Element.getElementsBySelector(trElement, 'input');

                if (checkbox[0]) {
                    checked = isInput ? checkbox[0].checked : !checkbox[0].checked;
                    gridJsObject.setCheckboxChecked(checkbox[0], checked);
                }
            }
        }

        /**
         * Change teaser item position
         *
         * @param {String} event
         */
        function positionChange(event) {
            var element = Event.element(event);

            if (element && element.checkboxElement && element.checkboxElement.checked) {
                teaserGroupItems.set(element.checkboxElement.value, element.value);
                $('in_teaser_group_items').value = Object.toJSON(teaserGroupItems);
            }
        }

        /**
         * Initialize TeaserGroup Item row
         *
         * @param {Object} grid
         * @param {String} row
         */
        function teaserGroupItemRowInit(grid, row) {
            var checkbox = $(row).getElementsByClassName('checkbox')[0],
                position = $(row).getElementsByClassName('input-text')[0];

            if (checkbox && position) {
                checkbox.positionElement = position;
                position.checkboxElement = checkbox;
                position.disabled = !checkbox.checked;
                position.tabIndex = tabIndex++;
                Event.observe(position, 'keyup', positionChange);
            }
        }

        gridJsObject.rowClickCallback = teaserGroupItemRowClick;
        gridJsObject.initRowCallback = teaserGroupItemRowInit;
        gridJsObject.checkboxCheckCallback = registerTeaserGroupItem;

        if (gridJsObject.rows) {
            gridJsObject.rows.each(function (row) {
                teaserGroupItemRowInit(gridJsObject, row);
            });
        }
    };
});
