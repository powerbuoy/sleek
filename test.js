const request = require('request');
const fs = require('fs');

console.log('sending request...');

request.post({
	url: 'http://fontello.com',
	formData: {config: fs.createReadStream('src/icons.json', 'utf8')}
}, (err, res, body) => {
	if (err) {
		return console.error(err);
	}

	request.get(`http://fontello.com/${body}/get`, (err2, res2, body2) => {
		console.log(body2);
	});
});
