var Cartesian = function (a, b) {
    var ret = [];
    for (var i = 0; i < a.length; i++) {
        for (var j = 0; j < b.length; j++) {
            ret.push(ft(a[i], b[j]));
        }
    }
    return ret;
}
var ft = function (a, b) {
    if (!(a instanceof Array))
        a = [a];
    var ret = Array.call(null, a);
    ret.push(b);
    return ret;
}

var multiCartesian = function (data) {
    var len = data.length;
    if (len == 0) {
        return [];
    }
    else if (len == 1) {
        var r = new Array();
        var d = data[0];
        for (var i = 0; i < d.length; i++) {
            r.push(new Array(d[i]));
        }
        return r;
    }
    else {
        var r = data[0];
        for (var i = 1; i < len; i++) {
            r = Cartesian(r, data[i]);
        }
        return r;
    }
}


function HashMap() {
    //定义长度
    var length = 0;
    //创建一个对象
    var obj = new Object();

    /**
     * 判断Map是否为空
     */
    this.isEmpty = function () {
        return length == 0;
    };

    /**
     * 判断对象中是否包含给定Key
     */
    this.containsKey = function (key) {
        return (key in obj);
    };

    /**
     * 判断对象中是否包含给定的Value
     */
    this.containsValue = function (value) {
        for (var key in obj) {
            if (obj[key] == value) {
                return true;
            }
        }
        return false;
    };

    /**
     *向map中添加数据
     */
    this.set = function (key, value) {
        if (!this.containsKey(key)) {
            length++;
        }
        obj[key] = value;
    };

    /**
     * 根据给定的Key获得Value
     */
    this.get = function (key) {
        return this.containsKey(key) ? obj[key] : null;
    };

    /**
     * 根据给定的Key删除一个值
     */
    this.remove = function (key) {
        if (this.containsKey(key) && (delete obj[key])) {
            length--;
        }
    };

    /**
     * 获得Map中的所有Value
     */
    this.values = function () {
        var _values = new Array();
        for (var key in obj) {
            _values.push(obj[key]);
        }
        return _values;
    };

    /**
     * 获得Map中的所有Key
     */
    this.keySet = function () {
        var _keys = new Array();
        for (var key in obj) {
            _keys.push(key);
        }
        return _keys;
    };

    /**
     * 获得Map的长度
     */
    this.size = function () {
        return length;
    };

    /**
     * 清空Map
     */
    this.clear = function () {
        length = 0;
        obj = new Object();
    };
}


function initSpecsDef(specsDefMap) {
    var attrs = document.querySelectorAll(".spec_attr");
    for (var j = 0; j < attrs.length; j++) {
        var attrId = attrs[j].getAttribute("attrId");
        var attrName = attrs[j].getAttribute("attrName");
        specsDefMap.set(attrId, attrName);
    }
}

function ProductImage(imageId, imageSrc, imageAlt, imageTitle) {
    this.imageId = imageId;
    this.imageSrc = imageSrc;
    this.imageAlt = imageAlt;
    this.imageTitle = imageTitle;
    this.getImageId = function () {
        return this.imageId;
    }
    this.getImageSrc = function () {
        return this.imageSrc;
    }
    this.getImageAlt = function () {
        return this.imageAlt;
    }
    this.getImageTitle = function () {
        return this.imageTitle;
    }
}

function initProductImageMap(productImageMap) {
    var nodes = document.querySelectorAll(".specs_product_images");
    for (var i = 0; i < nodes.length; i++) {
        var node = nodes[i];
        var imageId = node.getAttribute("imageId");
        var imageSrc = node.getAttribute("imageSrc");
        var imageAlt = node.getAttribute("imageAlt");
        var imageTitle = node.getAttribute("imageTitle");
        var productImage = new ProductImage(imageId, imageSrc, imageAlt, imageTitle);
        productImageMap.set(imageId, productImage);
    }
}


/**
 * 更改规格选项
 */
function changeSpecs() {
    var specsDefMap = new HashMap();
    var groupAttrMap = new HashMap();
    var productImageMap = new HashMap();

    initSpecsDef(specsDefMap);
    initProductImageMap(productImageMap);

    var attrGroups = document.querySelectorAll(".spec_attr_groups");
    var attrsArray = new Array();
    for (var i = 0; i < attrGroups.length; i++) {
        var attrGroup = attrGroups[i];
        var groupId = attrGroup.getAttribute("groupId");
        var attrs = attrGroup.querySelectorAll(".spec_attr");
        for (var j = 0; j < attrs.length; j++) {
            if (attrs[j].checked) {
                if (!groupAttrMap.containsKey(groupId)) {
                    groupAttrMap.set(groupId, new Array());
                }
                var attrArray = groupAttrMap.get(groupId);
                var attrId = attrs[j].getAttribute("attrId");
                attrArray.push(attrId);
            }
        }
        if (groupAttrMap.containsKey(groupId)) {
            attrsArray.push(groupAttrMap.get(groupId));
        }
    }
    var combinations = multiCartesian(attrsArray);
    // 创建规格列表
    createSpecList(specsDefMap, combinations);
    // 创建规格图片 -- 暂时屏蔽规格组合选择图片的功能
    // createSpecImages(specsDefMap, combinations, productImageMap);

    var combResultNode = $(".specs_comb_list");
    if (attrsArray.length > 0) {
        combResultNode.show();
    }
    else {
        combResultNode.hide();
    }
};


/**
 * 创建规格列表
 * @param specsDefMap
 * @param combinations
 */
function createSpecList(specsDefMap, combinations) {
    var specsCacheNode = document.querySelector("#specs_cache");
    var table = document.querySelector("#specs_list");
    var tbody = table.querySelector("tbody");
    for (var i = tbody.rows.length - 1; i >= 0; i--) {
        tbody.deleteRow(i);
    }
    for (var i = 0; i < combinations.length; i++) {
        var combination = combinations[i];
        // 生成组合ID 715_810
        var combinationIds = generateCombinationIds(combination);
        // 生成组合的描述字符串
        var combinationDescs = generateCombinationDesc(combination, specsDefMap);
        var row = tbody.insertRow(-1);
        var cell = row.insertCell(-1);
        cell.innerHTML = '<input type=hidden name="attr_combination[]" value="' + combinationIds + '">' + combinationDescs;
        cell = row.insertCell(-1);
        var nodeValue = "";
        var node = specsCacheNode.querySelector("#comb_" + combinationIds + "_ref");
        if (node != null) {
            nodeValue = node.getAttribute("value");
        }
        cell.innerHTML = '<input name="specs_ref[]" value="' + nodeValue + '" class="form_input" size="12" maxlength="64" type="text">';

        cell = row.insertCell(-1);
        nodeValue = "0";
        node = specsCacheNode.querySelector("#comb_" + combinationIds + "_price");
        if (node != null) {
            nodeValue = node.getAttribute("value");
        }
        cell.innerHTML = '<input name="specs_price[]" value="' + nodeValue + '" class="form_input" size="5" maxlength="10" type="text">';

        cell = row.insertCell(-1);
        nodeValue = "0";
        node = specsCacheNode.querySelector("#comb_" + combinationIds + "_weight");
        if (node != null) {
            nodeValue = node.getAttribute("value");
        }
        cell.innerHTML = '<input name="specs_weight[]" value="' + nodeValue + '" class="form_input" size="5" maxlength="10" type="text">';

        cell = row.insertCell(-1);
        nodeValue = "1";
        node = specsCacheNode.querySelector("#comb_" + combinationIds + "_min_qty");
        if (node != null) {
            nodeValue = node.getAttribute("value");
        }
        cell.innerHTML = '<input name="specs_min_qty[]" value="' + nodeValue + '" class="form_input" size="4" maxlength="6" type="text">';

        cell = row.insertCell(-1);
        nodeValue = "99999";
        node = specsCacheNode.querySelector("#comb_" + combinationIds + "_stock_qty");
        if (node != null) {
            nodeValue = node.getAttribute("value");
        }
        cell.innerHTML = '<input name="specs_stock_qty[]" value="' + nodeValue + '" class="form_input" size="4" maxlength="6" type="text">';
    }
}

/**
 * 创建规格图片
 * @param specsDefMap
 * @param combinations
 * @param productImageMap
 */
function createSpecImages(specsDefMap, combinations, productImageMap) {
    var productImageIds = productImageMap.keySet();
    var specsCacheNode = document.querySelector("#specs_images_cache");
    var table = document.querySelector("#specs_images");
    var tbody = table.querySelector("tbody");
    for (var i = tbody.rows.length - 1; i >= 0; i--) {
        tbody.deleteRow(i);
    }
    for (var i = 0; i < combinations.length; i++) {
        var combination = combinations[i];
        // 生成组合ID 715_810
        var combinationIds = generateCombinationIds(combination);
        // 生成组合的描述字符串
        var combinationDescs = generateCombinationDesc(combination, specsDefMap);
        // 获取该组合的image
        var node = specsCacheNode.querySelector("#comb_" + combinationIds + "_images");
        var selectedImagesComb = "";
        if (node != null) {
            selectedImagesComb = node.getAttribute("value");
        }
        var selectedImageIds = selectedImagesComb.split("_");

        var row = tbody.insertRow(-1);
        var cell = row.insertCell(-1);
        cell.innerHTML = combinationDescs;

        cell = row.insertCell(-1);
        var divNode = document.createElement("div");
        divNode.setAttribute("class", "list-inline");
        cell.appendChild(divNode);
        for (var j = 0; j < productImageIds.length; j++) {
            var productImageId = productImageIds[j];
            var productImage = productImageMap.get(productImageId);
            var liNode = document.createElement("li");
            divNode.appendChild(liNode);
            var inputNode = document.createElement("input");
            var labelNode = document.createElement("label");
            liNode.appendChild(inputNode);
            liNode.appendChild(labelNode);
            //
            processImageInputNode(inputNode, combinationIds, productImage, selectedImageIds);
            processImageLabelNode(labelNode, productImage);
        }
    }
}

function processImageInputNode(inputNode, combinationIds, productImage, selectedImageIds) {
    inputNode.setAttribute("type", "checkbox");
    inputNode.setAttribute("name", "specs_images_" + combinationIds + "[]");
    inputNode.setAttribute("value", productImage.getImageId());
    inputNode.setAttribute("id", "id_image_attr_" + productImage.getImageId());
    if (selectedImageIds.some(function (item, index, array) {
            return item == productImage.getImageId();
        })) {
        inputNode.setAttribute("checked", "checked");
    }

}

function processImageLabelNode(labelNode, productImage) {
    labelNode.setAttribute("for", "id_image_attr_" + productImage.getImageId());
    var imgNode = document.createElement("img");
    imgNode.setAttribute("class", "img-thumbnail");
    imgNode.setAttribute("src", productImage.getImageSrc());
    imgNode.setAttribute("alt", productImage.getImageAlt());
    imgNode.setAttribute("title", productImage.getImageTitle());

    labelNode.appendChild(imgNode);
}


function generateCombinationIds(combination) {
    return combination.join("_");
}

function generateCombinationDesc(combination, specsDefMap) {
    var descs = new Array();
    for (var i = 0; i < combination.length; i++) {
        var attrId = combination[i];
        var desc = attrId;
        if (specsDefMap.containsKey(attrId)) {
            desc = specsDefMap.get(attrId);
        }
        descs.push(desc);
    }
    return descs.join(" + ");
}


function syncData(name) {
    var nodes = document.querySelectorAll("[name='" + name + "']");
    var len = nodes.length;
    if (len > 1) {
        var firstValue = nodes[0].value;
        if (firstValue != null && firstValue != "") {
            for (var i = 1; i < len; i++) {
                nodes[i].value = firstValue;
            }
        }
    }

}