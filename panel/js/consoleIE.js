if (!(window.console && console.log)) {
(function() {
var noop = function() {},
console = window.console = {};
methods = 'assert clear count debug dir dirxml error exception group groupCollapsed groupEnd info log markTimeline profile profileEnd markTimeline table time timeEnd timeStamp trace warn',
methods = methods.split(' ');
for(x in methods){
console[methods[x]] = noop;
}
}());
}