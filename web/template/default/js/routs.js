var Route = {
    index: "/",
    login: "/login",
    logout: "/logout",
    manager: "/manager/{id}",
    managers: "/managers",
    access_setting: "/manager/access_setting/{id}",
    manager_edit: "/manager/edit/{id}",
    access_groups: "/access_groups",
    access_group_create: "/access_group/create",
    access_group: "/access_group/{id}",
    category: "/category",
    manufacture: "/manufacturer",
    manufacture_group: "/manufacture_groups",
    products: "/products",
    products_archive: "/products/archive",
    add_product: "/products/add",
    to_archive: "/products/to_archive/{id}",
    un_archive: "/products/un_archive/{id}",
    copy_product: "/products/copy",
    coupons: "/coupons",
    order: "/order/{id}",
    orders_all: "/orders",
    orders: "/orders/view/{type}",
    clients: "/clients",
    client_orders: "/client/orders/{id}",
    client_group: "/clients_group",
    work_schedule: "/work_schedule",
    404: "/page/error_404",
    nova_generate: "/nova_post/generate/{id}"

};


function route(key, parameters) {
    var rout = '';

    if (Route !== undefined)
        rout = Route[key];

    for (var i in parameters) {
        var pattern = '{' + i + '}';
        var matches = rout.search(pattern);
        if (matches !== -1)
            rout = rout.replace(pattern, parameters[i]);
    }

    return my_url + rout;
}

function parameters(object) {
    var str = '?';
    for (var i in object) {
        str += i + '=' + object[i] + '&';
    }
    return str;
}
