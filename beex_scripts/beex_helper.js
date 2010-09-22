var MD5 = function (string) {
 
	function RotateLeft(lValue, iShiftBits) {
		return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
	}
 
	function AddUnsigned(lX,lY) {
		var lX4,lY4,lX8,lY8,lResult;
		lX8 = (lX & 0x80000000);
		lY8 = (lY & 0x80000000);
		lX4 = (lX & 0x40000000);
		lY4 = (lY & 0x40000000);
		lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
		if (lX4 & lY4) {
			return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
		}
		if (lX4 | lY4) {
			if (lResult & 0x40000000) {
				return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
			} else {
				return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
			}
		} else {
			return (lResult ^ lX8 ^ lY8);
		}
 	}
 
 	function F(x,y,z) { return (x & y) | ((~x) & z); }
 	function G(x,y,z) { return (x & z) | (y & (~z)); }
 	function H(x,y,z) { return (x ^ y ^ z); }
	function I(x,y,z) { return (y ^ (x | (~z))); }
 
	function FF(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function GG(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function HH(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function II(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function ConvertToWordArray(string) {
		var lWordCount;
		var lMessageLength = string.length;
		var lNumberOfWords_temp1=lMessageLength + 8;
		var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
		var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
		var lWordArray=Array(lNumberOfWords-1);
		var lBytePosition = 0;
		var lByteCount = 0;
		while ( lByteCount < lMessageLength ) {
			lWordCount = (lByteCount-(lByteCount % 4))/4;
			lBytePosition = (lByteCount % 4)*8;
			lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
			lByteCount++;
		}
		lWordCount = (lByteCount-(lByteCount % 4))/4;
		lBytePosition = (lByteCount % 4)*8;
		lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
		lWordArray[lNumberOfWords-2] = lMessageLength<<3;
		lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
		return lWordArray;
	};
 
	function WordToHex(lValue) {
		var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
		for (lCount = 0;lCount<=3;lCount++) {
			lByte = (lValue>>>(lCount*8)) & 255;
			WordToHexValue_temp = "0" + lByte.toString(16);
			WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
		}
		return WordToHexValue;
	};
 
	function Utf8Encode(string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	};
 
	var x=Array();
	var k,AA,BB,CC,DD,a,b,c,d;
	var S11=7, S12=12, S13=17, S14=22;
	var S21=5, S22=9 , S23=14, S24=20;
	var S31=4, S32=11, S33=16, S34=23;
	var S41=6, S42=10, S43=15, S44=21;
 
	string = Utf8Encode(string);
 
	x = ConvertToWordArray(string);
 
	a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
 
	for (k=0;k<x.length;k+=16) {
		AA=a; BB=b; CC=c; DD=d;
		a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
		d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
		c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
		b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
		a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
		d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
		c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
		b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
		a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
		d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
		c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
		b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
		a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
		d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
		c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
		b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
		a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
		d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
		c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
		b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
		a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
		d=GG(d,a,b,c,x[k+10],S22,0x2441453);
		c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
		b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
		a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
		d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
		c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
		b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
		a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
		d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
		c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
		b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
		a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
		d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
		c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
		b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
		a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
		d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
		c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
		b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
		a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
		d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
		c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
		b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
		a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
		d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
		c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
		b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
		a=II(a,b,c,d,x[k+0], S41,0xF4292244);
		d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
		c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
		b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
		a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
		d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
		c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
		b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
		a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
		d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
		c=II(c,d,a,b,x[k+6], S43,0xA3014314);
		b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
		a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
		d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
		c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
		b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
		a=AddUnsigned(a,AA);
		b=AddUnsigned(b,BB);
		c=AddUnsigned(c,CC);
		d=AddUnsigned(d,DD);
	}
 
	var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);
 
	return temp.toLowerCase();
}

function zipToState(zip) {
  var state;
	if (zip >= '99501' && zip <= '99950')  { state = 'AK'; }
	else if (zip >= '35004' && zip <= '36925')  { state = 'AL'; }
	else if (zip >= '71601' && zip <= '72959')  { state = 'AR'; }
	else if (zip >= '75502' && zip <= '75502')  { state = 'AR'; }
	else if (zip >= '85001' && zip <= '86556')  { state = 'AZ'; }
	else if (zip >= '90001' && zip <= '96162')  { state = 'CA'; }
	else if (zip >= '80001' && zip <= '81658')  { state = 'CO'; }
	else if (zip >= '06001' && zip <= '06389')  { state = 'CT'; }
	else if (zip >= '06401' && zip <= '06928')  { state = 'CT'; }
	else if (zip >= '20001' && zip <= '20039')  { state = 'DC'; }
	else if (zip >= '20042' && zip <= '20599')  { state = 'DC'; }
	else if (zip >= '20799' && zip <= '20799')  { state = 'DC'; }
	else if (zip >= '19701' && zip <= '19980')  { state = 'DE'; }
	else if (zip >= '32004' && zip <= '34997')  { state = 'FL'; }
	else if (zip >= '30001' && zip <= '31999')  { state = 'GA'; }
	else if (zip >= '39901' && zip <= '39901')  { state = 'GA'; }
	else if (zip >= '96701' && zip <= '96898')  { state = 'HI'; }
	else if (zip >= '50001' && zip <= '52809')  { state = 'IA'; }
	else if (zip >= '68119' && zip <= '68120')  { state = 'IA'; }
	else if (zip >= '83201' && zip <= '83876')  { state = 'ID'; }
	else if (zip >= '60001' && zip <= '62999')  { state = 'IL'; }
	else if (zip >= '46001' && zip <= '47997')  { state = 'IN'; }
	else if (zip >= '66002' && zip <= '67954')  { state = 'KS'; }
	else if (zip >= '40003' && zip <= '42788')  { state = 'KY'; }
	else if (zip >= '70001' && zip <= '71232')  { state = 'LA'; }
	else if (zip >= '71234' && zip <= '71497')  { state = 'LA'; }
	else if (zip >= '01001' && zip <= '02791')  { state = 'MA'; }
	else if (zip >= '05501' && zip <= '05544')  { state = 'MA'; }
	else if (zip >= '20331' && zip <= '20331')  { state = 'MD'; }
	else if (zip >= '20335' && zip <= '20797')  { state = 'MD'; }
	else if (zip >= '20812' && zip <= '21930')  { state = 'MD'; }
	else if (zip >= '03901' && zip <= '04992')  { state = 'ME'; }
	else if (zip >= '48001' && zip <= '49971')  { state = 'MI'; }
	else if (zip >= '55001' && zip <= '56763')  { state = 'MN'; }
	else if (zip >= '63001' && zip <= '65899')  { state = 'MO'; }
	else if (zip >= '38601' && zip <= '39776')  { state = 'MS'; }
	else if (zip >= '71233' && zip <= '71233')  { state = 'MS'; }
	else if (zip >= '59001' && zip <= '59937')  { state = 'MT'; }
	else if (zip >= '27006' && zip <= '28909')  { state = 'NC'; }
	else if (zip >= '58001' && zip <= '58856')  { state = 'ND'; }
	else if (zip >= '68001' && zip <= '68118')  { state = 'NE'; }
	else if (zip >= '68122' && zip <= '69367')  { state = 'NE'; }
	else if (zip >= '03031' && zip <= '03897')  { state = 'NH'; }
	else if (zip >= '07001' && zip <= '08989')  { state = 'NJ'; }
	else if (zip >= '87001' && zip <= '88441')  { state = 'NM'; }
	else if (zip >= '88901' && zip <= '89883')  { state = 'NV'; }
	else if (zip >= '06390' && zip <= '06390')  { state = 'NY'; }
	else if (zip >= '10001' && zip <= '14975')  { state = 'NY'; }
	else if (zip >= '43001' && zip <= '45999')  { state = 'OH'; }
	else if (zip >= '73001' && zip <= '73199')  { state = 'OK'; }
	else if (zip >= '73401' && zip <= '74966')  { state = 'OK'; }
	else if (zip >= '97001' && zip <= '97920')  { state = 'OR'; }
	else if (zip >= '15001' && zip <= '19640')  { state = 'PA'; }
	else if (zip >= '02801' && zip <= '02940')  { state = 'RI'; }
	else if (zip >= '29001' && zip <= '29948')  { state = 'SC'; }
	else if (zip >= '57001' && zip <= '57799')  { state = 'SD'; }
	else if (zip >= '37010' && zip <= '38589')  { state = 'TN'; }
	else if (zip >= '73301' && zip <= '73301')  { state = 'TX'; }
	else if (zip >= '75001' && zip <= '75501')  { state = 'TX'; }
	else if (zip >= '75503' && zip <= '79999')  { state = 'TX'; }
	else if (zip >= '88510' && zip <= '88589')  { state = 'TX'; }
	else if (zip >= '84001' && zip <= '84784')  { state = 'UT'; }
	else if (zip >= '20040' && zip <= '20041')  { state = 'VA'; }
	else if (zip >= '20040' && zip <= '20167')  { state = 'VA'; }
	else if (zip >= '20042' && zip <= '20042')  { state = 'VA'; }
	else if (zip >= '22001' && zip <= '24658')  { state = 'VA'; }
	else if (zip >= '05001' && zip <= '05495')  { state = 'VT'; }
	else if (zip >= '05601' && zip <= '05907')  { state = 'VT'; }
	else if (zip >= '98001' && zip <= '99403')  { state = 'WA'; }
	else if (zip >= '53001' && zip <= '54990')  { state = 'WI'; }
	else if (zip >= '24701' && zip <= '26886')  { state = 'WV'; }
	else if (zip >= '82001' && zip <= '83128')  { state = 'WY'; }
	return state;
}
/**
 * DHTML email validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */

function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   //alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   //alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    //alert("Invalid E-mail ID")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    //alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    //alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    //alert("Invalid E-mail ID")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    //alert("Invalid E-mail ID")
		    return false
		 }

 		 return true					
	}
