 <!DOCTYPE html>
 <html lang="fr" class="js">

 <head>
     <meta charset="utf-8">
     <meta name="author" content="mfp">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <meta name="description" content="Interface de connexion de l'application Signature.">

     <!-- Fav Icon -->
     <link rel="shortcut icon" href="{{ asset('signature/images/favicon.png') }}">

     <!-- Page Title -->
     <title>@yield('title') - Plateforme de signature electronique E-Sign</title>

     @yield('styles')

 </head>

 <body class="nk-body bg-white npc-default pg-auth">

     <div class="nk-app-root">

         <!-- main @s -->
         <div class="nk-main">

             <!-- wrap @s -->
             <div class="nk-wrap nk-wrap-nosidebar">

                 <!-- content @s -->
                 <div class="nk-content">

                     <div class="nk-split nk-split-page nk-split-md">

                         <!-- ============================= -->
                         <!-- BEGIN: Login Section -->
                         <!-- ============================= -->
                         @yield('content')


                         <!-- ============================= -->
                         <!-- BEGIN: Promotional Section -->
                         <!-- ============================= -->
                         @include('sections.auth-image')
                     </div>
                     <!-- .nk-split -->

                 </div>
                 <!-- .nk-content -->

             </div>
             <!-- .nk-wrap -->

         </div>
         <!-- .nk-main -->

     </div>
     <!-- .nk-app-root -->

     @yield('scripts')
 </body>

 </html>
