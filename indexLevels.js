function loadLiquidGauge(id, value, color, animateTime, waveHeight) {
  if (typeof(color) == "undefined") color = "#000";
  if (typeof(animateTime) == "undefined") animateTime = 1000;
  if (typeof(waveHeight) == "undefined") waveHeight = 0.05;
  
  var gauge = liquidFillGaugeDefaultSettings();
  gauge.circleColor = color;
  gauge.textColor = "#fff";
  gauge.waveTextColor = "#fff";
  gauge.waveColor = color;
  gauge.circleThickness = 0.1;
  gauge.textVertPosition = 0.5;
  gauge.waveHeight = waveHeight;
  gauge.waveAnimateTime = animateTime;
  
  loadLiquidFillGauge(id, value, gauge);
}

/*$(document).ready(function() {
  loadLiquidGauge("liquidGaugeLava",72, "#f00", 2500);
  loadLiquidGauge("liquidGaugeWater", 100 , "#00f", 1000);
  loadLiquidGauge("liquidGaugeOil", 52, "#444", 1500);
  loadLiquidGauge("liquidGaugeFuel", 32, "#cb3", 3500, 0.1);
});*/