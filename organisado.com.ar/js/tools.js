/* globals */
var lastValue, typingTimer, scheduleTimeout = 500;

/*! \brief function call scheduler, anti overwhelm
*/
function scheduleCall(obj, f)
{
	if( obj && obj.value != lastValue )
	{
		lastValue = obj.value;

		clearTimeout(typingTimer);
		
		typingTimer = setTimeout(function() {
			f(obj.value);
		}, scheduleTimeout);
	}
}