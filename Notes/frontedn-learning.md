[The "checked" binding](http://knockoutjs.com/documentation/checked-binding.html)

[把checkbox变成按钮](http://jqueryui.com/button/#checkbox)

checked:$root.switchDevices;

<!-- ko ><-- >

myViewModel.personName.subscribe(function (){}) 监听change事件

subscription.dispose(); 关闭监听

        <ul>
            <li class="header">Header item</li>
            <!-- ko foreach: myItems -->
                <li>Item <span data-bind="text: $data"></span></li>
            <!-- /ko -->
        </ul>
         
        <script type="text/javascript">
            ko.applyBindings({
                myItems: [ 'A', 'B', 'C' ]
            });
        </script>
