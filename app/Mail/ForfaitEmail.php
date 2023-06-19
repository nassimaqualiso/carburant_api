<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForfaitEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $objet;
    protected $contenu;
    protected $piece_jointe;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($objet, $contenu, $piece_jointe){
        $this->objet = $objet;
        $this->contenu = $contenu;
        $this->piece_jointe = $piece_jointe;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(!is_null($this->piece_jointe)){
            return $this->markdown('forfait-markdown')
            ->subject($this->objet)
            ->with([    
                'contenu' => $this->contenu,
            ])
            ->attach(storage_path('app/public').'/'.$this->piece_jointe); 
        }else{
            return $this->markdown('forfait-markdown')
            ->subject($this->objet)
            ->with([    
                'contenu' => $this->contenu,
            ]);
        }
    }
}
