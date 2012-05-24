var dd = {};

dd.useragent = {
	
	initialize: function() {
	  this.BrowserDetect.init();
		
		this.browser = {
			name: this.BrowserDetect.browser,
			version: this.BrowserDetect.version
		};
		
		this.os = {
			name: this.BrowserDetect.OS
		};
	},
	
	add_agent_classes: function() {
		var classes = [
			this.browser.name,
			this.os.name,
			this.os.version
		].concat(this.version_strings(jQuery.browser.version));
		
		jQuery('body').addClass(classes.join(" "));
	},
	
	version_strings: function(version_string) {
		var possible_versions = [];
		var segments = version_string.split(".");
		
		var segments_to_check = [];
		while (segments.length > 0) {
			segments_to_check.push(segments.shift());
			possible_versions.push(this.browser.name + "_" + segments_to_check.join("-"));
		}
		
		return possible_versions;
	},
	
	// http://www.quirksmode.org/js/detect.html
	BrowserDetect: {
		init: function () {
			this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
			this.version = this.searchVersion(navigator.userAgent)
				|| this.searchVersion(navigator.appVersion)
				|| "unknown_OS_version";
			this.OS = this.searchString(this.dataOS) || "unknown_OS";
		},
		searchString: function (data) {
			for (var i=0;i<data.length;i++)	{
				var dataString = data[i].string;
				var dataProp = data[i].prop;
				this.versionSearchString = data[i].versionSearch || data[i].identity;
				if (dataString) {
					if (dataString.indexOf(data[i].subString) != -1) {
						return data[i].identity;
					}
				}
				else if (dataProp)
					return data[i].identity;
			}
		},
		searchVersion: function (dataString) {
			var index = dataString.indexOf(this.versionSearchString);
			if (index == -1) return;
			return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
		},
		dataBrowser: [
			{
				string: navigator.userAgent,
				subString: "Chrome",
				identity: "chrome"
			},
			{
			  string: navigator.userAgent,
				subString: "OmniWeb",
				versionSearch: "OmniWeb/",
				identity: "omniWeb"
			},
			{
			  string: navigator.vendor,
			  subString: "Mobile Safari",
			  identity: "mobile_safari",
			  versionSearch: "Version"
			},
			{
				string: navigator.vendor,
				subString: "Apple",
				identity: "safari",
				versionSearch: "Version"
			},
			{
				prop: window.opera,
				identity: "opera"
			},
			{
				string: navigator.vendor,
				subString: "icab",
				identity: "icab"
			},
			{
				string: navigator.vendor,
				subString: "KDE",
				identity: "konqueror"
			},
			{
				string: navigator.userAgent,
				subString: "Firefox",
				identity: "firefox",
				versionSearch: "Firefox/"
			},
			{
				string: navigator.vendor,
				subString: "Camino",
				identity: "camino"
			},
			{		// for newer Netscapes (6+)
				string: navigator.userAgent,
				subString: "Netscape",
				identity: "netscape"
			},
			{
				string: navigator.userAgent,
				subString: "MSIE",
				identity: "ie",
				versionSearch: "MSIE"
			},
			{
				string: navigator.userAgent,
				subString: "Gecko",
				identity: "mozilla",
				versionSearch: "rv"
			},
			{ 		// for older Netscapes (4-)
				string: navigator.userAgent,
				subString: "Mozilla",
				identity: "netscape_lte4",
				versionSearch: "Mozilla"
			}
		],
		dataOS : [
			{
				string: navigator.platform,
				subString: "Win",
				identity: "windows"
			},
			{
				string: navigator.appVersion,
				subString: "Mac OS X 10_4",
				identity: "mac tiger"
			},
			{
				string: navigator.appVersion,
				subString: "Mac OS X 10_5",
				identity: "mac leopard"
			},
			{
				string: navigator.appVersion,
				subString: "Mac OS X 10_6",
				identity: "mac snowleopard"
			},
			
			// fixes for mac/firefox
			{
				string: navigator.userAgent,
				subString: "Mac OS X 10.4",
				identity: "mac tiger"
			},
			{
				string: navigator.userAgent,
				subString: "Mac OS X 10.5",
				identity: "mac leopard"
			},
			{
				string: navigator.userAgent,
				subString: "Mac OS X 10.6",
				identity: "mac snowleopard"
			},
			// end of fixes for mac/firefox
			
			{
			  string: navigator.userAgent,
			  subString: "iPod",
			  identity: "ipod"
			},
			{
				string: navigator.userAgent,
				subString: "iPhone",
				identity: "iphone"
			},
			{
				string: navigator.userAgent,
				subString: "iPad",
				identity: "ipad"
			},
			{
				string: navigator.platform,
				subString: "Linux",
				identity: "linux"
			}
		]
	}
};
dd.useragent.initialize();
jQuery(function() {
	dd.useragent.add_agent_classes();
});