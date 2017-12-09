function ajaxRequest(event) {
    event.preventDefault();
    var attr = getAttributes(this),
        serialized = {},
        m,
        callbackName = null;

    // serialize data
    for (var key in attr) {
        if (m = key.match(/data-(\w+)/i)) {
            if (m[1] == 'callback') {
                callbackName = attr[key];
                continue;
            }
            serialized[m[1]] = attr[key];
        }
    }

    $.ajax({
        url: attr.href,
        method: 'GET',
        data: serialized,
        dataType: 'json',
        success: function (responce) {
            if (typeof window[callbackName] !== 'function')
                throw new Error("Function not isset pleace create!");
            else
                window[callbackName](responce);
        },
        error: function () {
            console.log('Some error! chek your data!');
        }
    });
}

function getAttributes(node) {
    var i,
        attributeNodes = node.attributes,
        length = attributeNodes.length,
        attrs = {};

    for (i = 0; i < length; i++) attrs[attributeNodes[i].name] = attributeNodes[i].value;
    return attrs;
}

$(document).on('click', '.ajaxRequest', ajaxRequest);
// end event listener ajax

// some instuction

// create some entity with class="ajaxRequest" and set some properties like data-id="dfs" ...
// and don`t forget data-callback="nameFunction" and create this function in js file
// when you click on this element request will sent to destination defined into href="some/path/to/destination"!