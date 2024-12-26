function download(filename) {
    var result = false;
    if (filename) {
        var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
        var j = 0;
        tab = document.getElementById("fikri-request");
        for (j = 0; j < tab.rows.length; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
        }
        tab_text = tab_text + "</table>";

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        var element = document.createElement("a");
        element.setAttribute(
            "href",
            "data:application/vnd.ms-excel," + encodeURIComponent(tab_text)
        );
        element.setAttribute("download", filename);

        element.style.display = "none";
        document.body.appendChild(element);

        element.click();

        document.body.removeChild(element);

        result = true;
    }

    return result;
}

function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "." : thousands_sep,
        dec = typeof dec_point === "undefined" ? "," : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}

function logActivity(record) {
    $.ajax({
        url: "/user-log-activity",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            action: JSON.parse(record)[0],
            description: JSON.parse(record)[1],
            table: JSON.parse(record)[2],
            type: JSON.parse(record)[3],
            route: JSON.parse(record)[4],
        },
        success: function (response) {
            console.log(response);
        },
        error: function (e) {
            console.log(e);
        },
    });
}

function formatNumber(s) {
    var parts = s.split(/,/);
    var spaced = parts[0]
        .split("")
        .reverse()
        .join("")
        .match(/\d{1,3}/g)
        .join(" ")
        .split("")
        .reverse()
        .join("");
    return spaced + (parts[1] ? "," + parts[1] : "");
}

function maskingInput() {
    $(".uangMasking").mask("0.000.000.000.000.000.000.000", { reverse: true });
}

function validateSymbol() {
    $(".number-only-keydown").on("keydown", function (e) {
        var invalidChars = ["-", "+", "e"];
        if (invalidChars.includes(e.key)) {
            e.preventDefault();
        }
    });
}
