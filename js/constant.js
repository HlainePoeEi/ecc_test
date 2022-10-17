//const WS_URL = "wss://" + location.hostname + ":9010";
//const WS_URL = "wss://172.16.15.87:9010/";
//const WS_URL = "wss://" + location.hostname + ":9010/activity/server3.php";
WS_URL = '';
if (location.hostname === 'localhost') {
	// テスト用
	WS_URL = "wss://" + location.hostname + ":9010";
} else if (location.hostname === '172.16.15.87') {
	WS_URL = "wss://" + location.hostname + ":9010";
} else if (location.hostname === '172.16.15.67') {
	WS_URL = "wss://172.16.15.67:8080";
} else  {
	// 本番用
	WS_URL = "wss://ecc-online-lesson.com:8080";
}