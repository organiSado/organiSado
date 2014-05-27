/* globals */
var lastValue, typingTimer, scheduleTimeout = 500;

/*! \brief function call scheduler, anti overwhelm
*/
function scheduleCall(obj, f, useObj)
{
	if (!useObj) useObj = false;

	if( obj && obj.value != lastValue )
	{
		lastValue = obj.value;

		clearTimeout(typingTimer);
		
		typingTimer = setTimeout(function() {
			if (useObj)
			{
				f(obj);
			}
			else
			{
				f(obj.value);
			}
		}, scheduleTimeout);
	}
}

var watchdogInterval = 500;
var watchdogObj, watchdogLastValue, watchdogTimer;

/*! \brief watchdog
*/
function startWatchdog(obj, f)
{
	if (watchdogObj != obj) stopWatchdog();

	watchdogObj = obj;
	watchdogLastValue = watchdogObj.innerHTML;

	watchdogTimer = setInterval(function()
	{
		if (watchdogObj.innerHTML != watchdogLastValue)
		{
			watchdogLastValue = watchdogObj.innerHTML;
			f(obj);
		}
	}, watchdogInterval);
}

function stopWatchdog(obj, f)
{
	clearInterval(watchdogTimer);
}