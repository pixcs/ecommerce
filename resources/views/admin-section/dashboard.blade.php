<section id="dashboard-section" class="p-6">
    <div class="grid grid-cols-2 grid-rows-2 gap-10">
        <div
            class="h-80  text-5xl flex items-center justify-center gap-x-5 shadow-md hover:shadow-xl hover:text-green-500 transition duration-300">
            <h2 class="md:text-2xl lg:text-3xl">Total Products</h2>
            <i class="fa-solid fa-box"></i>
            <p class="text-5xl">{{ $products->count() }}</p>
        </div>
        <div
            class="h-80 flex items-center justify-center gap-x-5 shadow-md hover:shadow-xl hover:text-rose-500 transition duration-300">
            <h2 class="md:text-2xl lg:text-3xl">Total Orders</h2>
            <i class="fa-solid fa-cart-shopping text-5xl"></i>
            <p class="text-5xl">{{ $orders->count() }}</p>
        </div>
        <div id="con" class="h-80 shadow-md hover:shadow-xl transition duration-300"></div>
        <div id="pie-chart" class="h-80 shadow-md hover:shadow-xl transition duration-300"></div>
    </div>
</section>

<script>
    $(document).ready(() => {

        $.ajax({
            type: "GET",
            url: `{{ route('get.products') }}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (res) => {
                console.log("dashboard", res);

                const formattedData = res.map(product => ({
                    name: product.product_name,
                    y: parseFloat(product.price)
                }));

                console.log("Formatted data:", formattedData);

                Highcharts.chart('pie-chart', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: 'Total Products'
                    },
                    tooltip: {
                        valuePrefix: '₱'
                    },
                    subtitle: {
                        text: 'Source:<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default">MDPI</a>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.percentage:.1f}%'
                            }
                        }
                    },
                    series: [{
                        name: 'Price',
                        colorByPoint: true,
                        data: formattedData
                    }]
                });


                const categories = res.map(product => product.product_name);
                const data = res.map(product => parseFloat(product.price));

                Highcharts.chart('con', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Total Product Prices',
                        align: 'left'
                    },
                    subtitle: {
                        text: 'Source: Your Product Data',
                        align: 'left'
                    },
                    xAxis: {
                        categories: categories,
                        crosshair: true,
                        accessibility: {
                            description: 'Product Names'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Price (PESO)'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' PHP'
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Product Prices',
                        data: data
                    }]
                });
            },
            error: (res) => {
                console.error(res);
            }
        });
        
    })
</script>
