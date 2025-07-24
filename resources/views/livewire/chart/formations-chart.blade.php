<div
    x-data="chartComponent()"
    x-init="init()"
    wire:ignore
    class="w-full p-4"
>
    <div x-ref="myChart" class="w-full p-4"></div>
</div>

<script>
    function chartComponent() {
        return {
            chart: null,
            init() {
                if (this.chart) return;

                const options = {
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: { show: false },
                    },
                    series: [{
                        name: 'Formations',
                        data: @json(array_values($chartData)),
                    }],
                    xaxis: {
                        categories: @json(array_keys($chartData)),
                    },
                    colors: ['#4f46e5'],
                };

                this.chart = new ApexCharts(this.$refs.myChart, options);
                this.chart.render();
            }
        };
    }
</script>
