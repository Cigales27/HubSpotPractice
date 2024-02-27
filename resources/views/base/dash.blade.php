
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        /* Add your CSS styles here */
        .sidebar {
            width: 200px;
            background-color: #fe6161;
            float: left;
            height: 100vh;
            height: calc(100vh - 20px);
            padding: 20px;
        }
        .slider div{
          color: aliceblue;
          font-size: 20px;
          margin: 10px;
          border-radius: 5px;
          background-color: #fe6161;
          text-align: center;          
        }

        .slider ul li:hover{
          background-color: #f5f5f5;
          color: #fe6161;
          cursor: pointer;
        }

        .slider div:active{
          background-color: #fe6161;
          color: #f5f5f5;
        }

        li{
          list-style: none;
          padding: 0.5em;
          
          color: #f5f5f5;
          font-size: 1.5em;
        }
        
        .content {
            margin-left: 200px;
            padding: 20px;
        }
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 100px;
            height: 100px;
        }
    </style>
    @yield('css')
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="https://static.vecteezy.com/system/resources/previews/029/284/964/original/google-logo-on-transparent-background-popular-search-engine-google-logotype-symbol-icon-google-sign-stock-free-vector.jpg" alt="Logo">
        </div>
        <!-- Add your sidebar menu items here -->
        <ul>
            <li>Lista</li>
            <li>Papelera</li>
        </ul>
    </div>
    <div class="content">
      @yield('contenido')
    </div>
    @yield('js')
</body>
</html>
