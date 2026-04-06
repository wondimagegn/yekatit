<script src="/js/angular.min.js"></script>
<script src="/js/chart.js"></script>
<script src="/js/angular-chart.min.js"></script>
<script src="/js/angular-route.min.js"></script>
<?php

function js_str($s)
{
	return '"' . addcslashes($s, "\0..\37\"\\") . '"';
}

function jsArray($arr)
{
	$temp = array_map("js_str", $arr);
	return '[' . implode(',', $temp) . ']';
}

function jsArrayData($arr)
{
	$string = "[";

	if (!empty($arr) && is_array($arr)) {
		foreach ($arr as $key => $value) {
			$temp = array_map("js_str", $value);
			$string .= '[' . implode(',', $temp) . '],';
		}
	}
	$string .= "]";
	//return '['.implode(',',$temp).']';
	return $string;
}

//$data = jsArray($distributionStatistics['graph']['labels']); 
//debug($data);
//debug($distributionStatistics);


if (isset($distributionStatistics['graph']) && !empty($distributionStatistics['graph'])) { ?>
	<div class="panel panel-default">

		<div class="panel-body">
			<canvas id="<?= $this->data['Staff']['graph_type']; ?>" class="chart chart-<?= $this->data['Staff']['graph_type']; ?>" chart-data="data" chart-series="series" chart-labels="labels" chart-colors="colors" chart-options="options">

			</canvas>
		</div>
	</div>

	<script type="text/javascript">
		//"chart.js"
		var generalReport = angular.module('generalReport', ['ngRoute', 'chart.js']);

		generalReport.controller('reportCntrl', ['$scope', '$http', function ($scope, $http) {
			$scope.options = { legend: { display: true } };
			$scope.colors = ['#da7493', '#428bca'];
			$scope.labels = <?= jsArray($distributionStatistics['graph']['labels']); ?>;
			$scope.series = <?= jsArray($distributionStatistics['graph']['series']); ?>;
			$scope.data = <?= jsArrayData($distributionStatistics['graph']['data']); ?>;

		}]);

	</script>
	<?php 
} ?>


<?php 
if (isset($distributionStatisticsStatus['graph']) && !empty($distributionStatisticsStatus['graph'])) { ?>
	<div class="panel panel-default">

		<div class="panel-body">
			<canvas id="<?= $this->data['Report']['graph_type']; ?>" class="chart chart-<?= $this->data['Report']['graph_type']; ?>" chart-data="data" chart-series="series" chart-labels="labels" chart-colors="colors" chart-options="options">

			</canvas>
		</div>
	</div>

	<script type="text/javascript">
		//"chart.js"
		var generalReport = angular.module('generalReport', ['ngRoute', 'chart.js']);

		generalReport.controller('reportCntrl', ['$scope', '$http', function ($scope, $http) {
			$scope.options = { legend: { display: true } };
			$scope.colors = ['#da7493', '#428bca'];
			$scope.labels = <?= jsArray($distributionStatisticsStatus['graph']['labels']); ?>;
			$scope.series = <?= jsArray($distributionStatisticsStatus['graph']['series']); ?>;
			$scope.data = <?= jsArrayData($distributionStatisticsStatus['graph']['data']); ?>;

		}]);
	</script>

	<?php 
} ?>