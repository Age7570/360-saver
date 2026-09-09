$(document).ready(function() {
	function getError(msg){
		return '<div class="alert alert-danger alert-dismissible fade show">'+msg+'</div>';
	}
    $("#form").submit(function() {
        function host(url) {
            var element = document.createElement('a');
            element.href = url.toLowerCase();
            final_url = element.hostname;
			console.log(final_url);
            switch (final_url) {
                case "www.instagram.com":
                    name = "instagram";
                    break;
                case "m.instagram.com":
                    name = "instagram";
                    break;
                case "instagram.com":
                    name = "instagram";
                    break;
                case "web.instagram.com":
                    name = "instagram";
                    break;
                default:
                    name = "null";
            }
            return name;
        }
        $("#downloadbox").hide();
		var url = $("#url").val();
		
		if(url==""){
			$("#downloadbox").html(getError("URL field can't be empty."));
			$("#downloadbox").show();
			return false;
		}
		if(!/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(url)){
			$("#downloadbox").html(getError("Invalid URL."));
			$("#downloadbox").show();
			return false;
		}
        $("#loading-ajax").show();
        $("#downloadbox").hide();
        $("#form_submit").attr("disabled", true);
        
        host = host(url);
		///console.log(host);
        $.post("core/ajax.php", {
                url: url,
                host: host
            },
            function(data, status) {
                $("#loading-ajax").hide();
                $("#downloadbox").html(data);
                $("#downloadbox").show();
                $("#form_submit").attr("disabled", false);
            });
        return false;
    });
});
