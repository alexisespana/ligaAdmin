<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">

    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                data-bs-placement="left" aria-label="Toggle Navigation" data-bs-original-title="Toggle Navigation"><span
                    class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
        </div><a class="navbar-brand" href="../../index.html">
            <div class="d-flex align-items-center py-3"><img class="me-2"
                    src="../../assets/img/icons/spot-illustrations/falcon.png" alt="" width="40"><span
                    class="font-sans-serif text-primary">falcon</span></div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            @forelse ($menus as $key=> $item)
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                    @if ($item[0]->tipo == 1)
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/starter.html" role="button">
                                <div class="d-flex align-items-center"><span class="nav-link-icon">
                                        <span class="fas fa-flag"></span></span><span
                                        class="nav-link-text ps-1">{{ $key }}</span></div>
                            </a>
                        </li>
                    @else
                        <li class = "{!! url()->current() === 'http://' . request()->getHttpHost() . $item[0]->href ? '' : '' !!} nav-item">

                            <a class="nav-link dropdown-indicator" href="#{{ $key }}" role="button"
                                data-bs-toggle="collapse" aria-expanded="false" aria-controls="{{ $key }}">
                                <div class="d-flex align-items-center"><span class="nav-link-icon">
                                        <span class="{{ $item[0]->MenuPadre->icono }}"></span></span>
                                    <span class="nav-link-text ps-1">{{ $key }}</span>
                                </div>
                            </a>


                            <ul class="nav collapse" id="{{ $key }}">
                                @forelse ($item as  $items)
                                    <li class = "{!! url()->current() === 'http://' . request()->getHttpHost() . $items->href ? 'active' : '' !!} nav-item">
                                        <a class="nav-link"href="{{ $items->href }}">
                                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">{{ $items->nombre }}</span></div>
                                        </a>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </li>
                    @endif



                @empty
                <div class="settings my-3">
                    <div class="card shadow-none">
                      <div class="card-body alert mb-0" role="alert">
                        <div class="text-center"><img src="../../assets/img/icons/spot-illustrations/navbar-vertical.png" alt="" width="80">
                          <p class="fs-11 mt-2">No tienes Modúlos asignados..</p>
                        </div>
                      </div>
                    </div>
                  </div>
                    
                </ul>
                @endforelse

        </div>
    </div>
</nav>
