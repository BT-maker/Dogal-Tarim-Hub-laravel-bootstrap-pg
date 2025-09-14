class AuthService{
    constructor(){
        this.baseURL = '/api/auth';
        this.token = localStorage.getItem('auth_token');
    }


    //SHA-256 ile şifre hashleme (crypto-js olmadan)
    async hashPassword(password){
        const encoder = new TextEncoder();
        const data = encoder.encode(password);
        const hashBuffer = await crypto.subtle.digest('SHA-256',data);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        return hashArray.map(b => b.toString(16).padStart(2,'0')).join('');
    }


    //API çağrısı için header
    getHeaders() {
        const headers = {
            'Content-Type':'application/json',
            'Accept':'application/json'
        };

        if (this.token){
            headers['Authorization']= `Bearer $[this.token]`;
        }

        return headers;
    }


    //Kayıt ol
}