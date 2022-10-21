var sql = require('mssql');
var config = new sql.ConnectionPool({
    
    server: "localhost",
    database: 'SRO_VT_ACCOUNT',
    user: 'sa',
    password: '3199462',
    port: 1433
});
config.connect(function (err) {
    if (err) throw err;
});


module.exports = config;