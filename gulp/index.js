var fs      = require('fs');
var tasks   = fs.readdirSync('./gulp/tasks/');

// Tasks loading
tasks.forEach(function(task) {
    require('./tasks/' + task);
});
