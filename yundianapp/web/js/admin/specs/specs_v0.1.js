    //笛卡尔积
    var Cartesian = function(a,b){
        var ret=[];
        for(var i=0;i<a.length;i++){
            for(var j=0;j<b.length;j++){
                ret.push(ft(a[i],b[j]));
            }
        }
        return ret;
    }
    var ft = function(a,b){
        if(!(a instanceof Array))
            a = [a];
        var ret = Array.call(null,a);
        ret.push(b);
        return ret;
    }
    //多个一起做笛卡尔积
    var multiCartesian = function(data){
        var len = data.length;
        if(len == 0) {
            return [];
        }
        else if(len == 1) {
            var r = new Array();
            var d = data[0];
            for(var i=0;i<d.length;i++){
                r.push(new Array(d[i]));
            }
            return r;
        }
        else{
            var r = data[0];
            for(var i=1;i<len;i++){
                r = Cartesian(r,data[i]);
            }
            return r;
        }
    }


    function createHashMap() {
        /* not work in strict mode : var 'this' is undifined*/
        var obj = new Object();
        obj.set = function(key,value){this[key] = value};
        obj.get = function(key){return this[key]};
        obj.contains = function(key){return this.get(key) == null?false:true};
        obj.remove = function(key){delete this[key];}
        return obj;
    }

    function HashMap(){
        //定义长度
        var length = 0;
        //创建一个对象
        var obj = new Object();

        /**
         * 判断Map是否为空
         */
        this.isEmpty = function(){
            return length == 0;
        };

        /**
         * 判断对象中是否包含给定Key
         */
        this.containsKey=function(key){
            return (key in obj);
        };

        /**
         * 判断对象中是否包含给定的Value
         */
        this.containsValue=function(value){
            for(var key in obj){
                if(obj[key] == value){
                    return true;
                }
            }
            return false;
        };

        /**
         *向map中添加数据
         */
        this.set=function(key,value){
            if(!this.containsKey(key)){
                length++;
            }
            obj[key] = value;
        };

        /**
         * 根据给定的Key获得Value
         */
        this.get=function(key){
            return this.containsKey(key)?obj[key]:null;
        };

        /**
         * 根据给定的Key删除一个值
         */
        this.remove=function(key){
            if(this.containsKey(key)&&(delete obj[key])){
                length--;
            }
        };

        /**
         * 获得Map中的所有Value
         */
        this.values=function(){
            var _values= new Array();
            for(var key in obj){
                _values.push(obj[key]);
            }
            return _values;
        };

        /**
         * 获得Map中的所有Key
         */
        this.keySet=function(){
            var _keys = new Array();
            for(var key in obj){
                _keys.push(key);
            }
            return _keys;
        };

        /**
         * 获得Map的长度
         */
        this.size = function(){
            return length;
        };

        /**
         * 清空Map
         */
        this.clear = function(){
            length = 0;
            obj = new Object();
        };
    }


    function changeSpecs() {
        var specsDefMap = new HashMap();
        var groupAttrMap = new HashMap();
        function initSpecsDef() {
            var attrs = document.querySelectorAll(".spec_attr");
            for (var j=0; j<attrs.length; j++) {
                var attrId = attrs[j].getAttribute("attrId");
                var attrName = attrs[j].getAttribute("attrName");
                specsDefMap.set(attrId, attrName);
            }
        }

        initSpecsDef();

        var attrGroups = document.querySelectorAll(".spec_attr_groups");
        var attrsArray = new Array();
        for(var i=0; i<attrGroups.length; i++) {
            var attrGroup = attrGroups[i];
            var groupId = attrGroup.getAttribute("groupId");
            var attrs = attrGroup.querySelectorAll(".spec_attr");
            for (var j=0; j<attrs.length; j++) {
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

        createSpecTable(specsDefMap, combinations);
    };



    function createSpecTable(specsDefMap, combinations) {
        var table = document.querySelector("#specs_list");
        var tbody = table.querySelector("tbody");
        for(var i=tbody.rows.length-1; i>=0; i--) {
            tbody.deleteRow(i);
        }
        for(var i=0;i<combinations.length;i++) {
            var combination = combinations[i];
            // 生成组合ID 715_810
            var combinationIds = generateCombinationIds(combination);
            // 生成组合的描述字符串
            var combinationDescs = generateCombinationDesc(combination, specsDefMap);
            var row = tbody.insertRow(-1);
            var cell = row.insertCell(-1);
            cell.innerHTML = '<input type=hidden name="attr_combination[]" value="' + combinationIds + '">' + combinationDescs;
            cell = row.insertCell(-1);
            cell.innerHTML = '<input name="specs_ref[]" value="" class="form_input" size="16" maxlength="64" type="text">';
            cell = row.insertCell(-1);
            cell.innerHTML = '<input name="specs_price[]" value="" class="form_input" size="5" maxlength="5" type="text">';
            cell = row.insertCell(-1);
            cell.innerHTML = '<input name="specs_weight[]" value="" class="form_input" size="5" maxlength="5" type="text">';
            cell = row.insertCell(-1);
            cell.innerHTML = '<input name="specs_min_qty[]" value="" class="form_input" size="5" maxlength="5" type="text">';
            cell = row.insertCell(-1);
            cell.innerHTML = '<input name="specs_stock_qty[]" value="" class="form_input" size="5" maxlength="5" type="text">';
        }
    }


    function generateCombinationIds(combination) {
        return combination.join("_");
    }

    function generateCombinationDesc(combination, specsDefMap) {
        var descs = new Array();
        for(var i=0;i<combination.length;i++) {
            var attrId = combination[i];
            var desc = attrId;
            if (specsDefMap.containsKey(attrId)) {
                desc = specsDefMap.get(attrId);
            }
            descs.push(desc);
        }
        return descs.join(" + ");
    }