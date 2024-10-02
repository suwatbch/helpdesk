if (window['google'] != undefined && window['google']['loader'] != undefined) {
    if (!window['google']['visualization']) {
        window['google']['visualization'] = {};
        google.visualization.Version = '1.0';
        google.visualization.JSHash = 'c044e0de584c55447c5597e76d372bc1';
        google.visualization.LoadArgs = 'file\75visualization\46v\0751\46packages\75orgchart';
    }
    // comment by sommart.j
    // google.loader.writeLoadTag("script", google.loader.ServiceBase + "/api/visualization/1.0/c044e0de584c55447c5597e76d372bc1/default,orgchart.I.js", false);
    google.loader.writeLoadTag("script", google.loader.ServiceBase + "/js/default,orgchart.I.js", false);
}
