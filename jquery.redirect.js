/*
 jQuery Redirect v1.0.3
 Copyright (c) 2013-2016 Miguel Galante
 Copyright (c) 2011-2013 Nemanja Avramovic, www.avramovic.info
 Licensed under CC BY-SA 4.0 License: http://creativecommons.org/licenses/by-sa/4.0/
 This means everyone is allowed to:
 Share - copy and redistribute the material in any medium or format
 Adapt - remix, transform, and build upon the material for any purpose, even commercially.
 Under following conditions:
 Attribution - You must give appropriate credit, provide a link to the license, and indicate if changes were made. You may do so in any reasonable manner, but not in any way that suggests the licensor endorses you or your use.
 ShareAlike - If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.
 */
(function ($) {
    'use strict';

    /**
     * jQuery Redirect
     * @param {string} url - Url of the redirection
     * @param {Object} values - (optional) An object with the data to send. If not present will look for values as QueryString in the target url.
     * @param {string} method - (optional) The HTTP verb can be GET or POST (defaults to POST)
     * @param {string} target - (optional) The target of the form. "_blank" will open the url in a new window.
     * @param {boolean} traditional - (optional) This provides the same function as jquery's ajax function. The brackets are omitted on the field name if its an array.  This allows arrays to work with MVC.net among others.
     */
    $.redirect = function (url, values, method, target, traditional) {
        method = (method && ["GET", "POST", "PUT", "DELETE"].indexOf(method.toUpperCase()) !== -1) ? method.toUpperCase() : 'POST';


        url = url.split("#");
        var hash = url[1] ? ("#" + url[1]) : "";
        url = url[0];

        if (!values) {
            var obj = $.parseUrl(url);
            url = obj.url;
            values = obj.params;
        }

        var form = $('<form>')
            .attr("method", method)
            .attr("action", url + hash);


        if (target) {
            form.attr("target", target);
        }

        var submit = {}; //Create a symbol
        form[0][submit] = form[0].submit;
        iterateValues(values, [], form, null, traditional);
        $('body').append(form);
        form[0][submit]();
    };

    //Utility Functions
    /**
     * Url and QueryString Parser.
     * @param {string} url - a Url to parse.
     * @returns {object} an object with the parsed url with the following structure {url: URL, params:{ KEY: VALUE }}
     */
    $.parseUrl = function (url) {

        if (url.indexOf('?') === -1) {
            return {
                url: url,
                params: {}
            };
        }
        var parts = url.split('?'),
            query_string = parts[1],
            elems = query_string.split('&');
        url = parts[0];

        var i, pair, obj = {};
        for (i = 0; i < elems.length; i+= 1) {
            pair = elems[i].split('=');
            obj[pair[0]] = pair[1];
        }

        return {
            url: url,
            params: obj
        };
    };

    //Private Functions
    var getInput = function (name, value, parent, array, traditional) {
        var parentString;
        if (parent.length > 0) {
            parentString = parent[0];
            var i;
            for (i = 1; i < parent.length; i += 1) {
                parentString += "[" + parent[i] + "]";
            }

            if (array) {
                if (traditional)
                    name = parentString;
                else
                    name = parentString + "[]";
            } else {
                name = parentString + "[" + name + "]";
            }
        }

        return $("<input>").attr("type", "hidden")
            .attr("name", name)
            .attr("value", value);
    };

    var iterateValues = function (values, parent, form, array, traditional) {
        var i, iterateParent = [];
        for (i in values) {
            if (typeof values[i] === "object") {
                iterateParent = parent.slice();
                if (array) {
                    iterateParent.push('');
                } else {
                    iterateParent.push(i);
                }
                iterateValues(values[i], iterateParent, form, Array.isArray(values[i]), traditional);
            } else {
                form.append(getInput(i, values[i], parent, array, traditional));
            }
        }
    };
}(window.jQuery || window.Zepto || window.jqlite));