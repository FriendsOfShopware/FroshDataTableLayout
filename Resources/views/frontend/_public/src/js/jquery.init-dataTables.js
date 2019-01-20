$(document).ready(function () {
    var parseQueryString = function(url) {
        var qparams = {},
            parts = (url || '').split('?'),
            qparts, qpart,
            i = 0;

        if (parts.length <= 1) {
            return qparams;
        }

        qparts = parts[1].split('&');
        for (i in qparts) {
            var key, value;

            qpart = qparts[i].split('=');
            key = decodeURIComponent(qpart[0]);
            value = decodeURIComponent(qpart[1] || '');
            qparams[key] = ($.isNumeric(value) ? parseFloat(value, 10) : value);
        }

        return qparams;
    };

    var rebuildQueryString = function(obj) {
        var str = [];
        for (var p in obj) {
            if (obj.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        }

        return str.join("&");
    }

    $dataTable = $('#dataTableListing');

    if ($dataTable.length && window.dataTableListingConfig) {
        window.dataTableListingConfig.ajax = {
            data: function() {
                var info = $dataTable.DataTable().page.info(),
                    queryObj = parseQueryString(window.location.href);

                if (queryObj.p) delete queryObj.p;
                if (queryObj.n) delete queryObj.n;

                var queryString = !$.isEmptyObject(queryObj) ? "&" + rebuildQueryString(queryObj) : "";

                console.log(queryObj);

                $dataTable.DataTable().ajax.url(
                    window.dataTableListingUrl
                    + "?p="
                    + (info.page + 1)
                    + "&n="
                    + info.length
                    + queryString
                );
            }
        };

        $dataTable.DataTable(
            window.dataTableListingConfig
        );
    }
});