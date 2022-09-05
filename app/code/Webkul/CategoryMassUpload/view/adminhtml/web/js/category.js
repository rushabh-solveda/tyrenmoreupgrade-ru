/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_CategoryMassUpload
 * @author    Webkul Software Private Limited
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
define([
    "jquery",
    "jquery/ui",
    ], function ($) {
        'use strict';
        $.widget('categorymassupload.category', {
            options: {},
            _create: function () {
                var self = this;
                $(document).ready(function () {
                    var skipCount = 0;
                    var importUrl = self.options.importUrl;
                    var finishUrl = self.options.finishUrl;
                    var total = self.options.categoryCount;
                    var completeLabel = self.options.completeLabel;
                    var noCategoryImportLabel = self.options.noCategoryImportLabel;
                    if (total > 0) {
                        var postData = self.options.postData;
                        importCategories(1);
                    }
                    function importCategories(count)
                    {
                        $.ajax({
                            type: 'post',
                            url:importUrl,
                            async: true,
                            dataType: 'json',
                            data : { 'count': count},
                            success:function (data) {
                                if (data['error'] == 1) {
                                    $(".fieldset").append(data['msg']);
                                    skipCount++;
                                } else {
                                    if (data['config_error'] == 1) {
                                        $(".fieldset").append(data['msg']);
                                    }
                                }
                                var width = (100/total)*count;
                                $(".wk-mu-progress-bar-current").animate({width: width+"%"},'slow', function () {
                                    if (total == 1 && skipCount ==1) {
                                        $(".fieldset").append('<div class="wk-mu-success wk-mu-box">'+noCategoryImportLabel+'</div>');
                                        $(".wk-mu-info-bar").addClass("wk-no-padding");
                                        $(".wk-mu-importing-loader").remove();
                                        $(".wk-mu-info-bar-content").text(completeLabel);
                                    } else {
                                        if (count == total) {
                                            finishImporting(count, skipCount);
                                        } else {
                                            count++;
                                            $(".wk-current").text(count);
                                            importCategories(count);
                                        }
                                    }
                                });
                            }
                        });
                    }
                    function finishImporting(count, skipCount)
                    {
                        $.ajax({
                            type: 'post',
                            url:finishUrl,
                            async: true,
                            dataType: 'json',
                            data : { row:count, skip:skipCount },
                            success:function (data) {
                                $(".fieldset").append(data['msg']);
                                $(".wk-mu-info-bar").addClass("wk-no-padding");
                                $(".wk-mu-info-bar").text(completeLabel);
                            }
                        });
                    }
                });
            }
        });
        return $.categorymassupload.category;
    });
    
