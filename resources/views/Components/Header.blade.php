<div id="navBar">
    <div class="navbar navbar-light bg-light justify-content-between">
        <a class="navbar-brand" href="/">Logo</a>
        <ul class="nav justify-content-end">
          <li class="nav-item">
            <a class="nav-link" href="#">
                Hello!  
                
                @if(session()->has('user_info')) 
                    {{ session()->get('user_info')['name'] }}
                @else
                    Guest
                @endif    
            </a>
          </li>
          <li class="nav-item">
            @if(session()->has('user_info')) 
                <a class="nav-link" href="#">Center</a>
            @else
                <a class="nav-link" href="/user/auth/sign-up">Register</a>
            @endif
          </li>
          <li class="nav-item">
            @if(session()->has('user_info')) 
                <a class="nav-link" href="/user/auth/sign-out">LogOut</a>
            @else
                <a class="nav-link" href="/user/auth/sign-in">LogIn</a>
            @endif
          </li>
        </ul>        
    </div>
</div>
