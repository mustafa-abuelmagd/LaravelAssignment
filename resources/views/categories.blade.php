@extends('Layout')

@section('content')
    <form>
        <label for="categories">Select a category:</label><br><br>
        @foreach($categories as $category)
            <ul>
                {{$category->id }}
                <input type="checkbox" id="{{{$category->id }}}" name="{{$category->name }}"
                       value="{{$category->name }} "> {{$category->name }} <br>
            </ul>
        @endforeach
    </form>
    <script type='text/javascript'>
        let checkboxes = document.querySelectorAll("input[type=checkbox]");

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    console.log("Checkbox is checked..", this);
                    let route = "http://localhost:8000/categories/" + checkbox.id;
                    loadDoc(route, checkbox.id);
                } else {
                    console.log("Checkbox is not checked..");
                }
            });

        })



        function loadDoc(route, parent_id) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    // document.getElementById(parent_id).innerHTML = this.responseText;
                    const parentNode = document.getElementById(parent_id)
                    const form = document.createElement("form");

                    const label = document.createElement("label");
                    parentNode.parentNode.appendChild(form);

                    JSON.parse(this.responseText)['data'].forEach((element) => {
                        console.log(element);

                        const ul = document.createElement("ul");
                        const input = document.createElement("input");
                        input.type = "checkbox";
                        input.id = element.id;
                        input.name = element.name;
                        input.addEventListener('change', function () {
                            if (this.checked) {
                                console.log("Checkbox is checked..", this);
                                let route = "http://localhost:8000/categories/" + input.id;
                                loadDoc(route, input.id);
                            } else {
                                console.log("Checkbox is not checked..");
                                document.getElementById(input.id).parentNode.remove();
                            }
                        });

                        const text = document.createTextNode('    ' + element.id + ' ')
                        const text2 = document.createTextNode(' ' + element.name)


                        label.appendChild(text);
                        label.appendChild(input);
                        label.appendChild(text2);
                        ul.appendChild(label);

                        form.appendChild(label);
                    });
                }
            };
            xhttp.open("GET", route, true);
            xhttp.send();
        }


    </script>

@endsection


