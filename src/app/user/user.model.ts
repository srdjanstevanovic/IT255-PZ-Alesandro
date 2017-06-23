

export class User {
    id: number;
    token: string;
    mail: string;
    addres: string;
    city_id: number;
    city: string;
    tin: number;
    role_id: number;
    role_name: string;

    constructor(id: number,
                token: string,
                mail: string,
                addres: string,
                city_id: number,
                city: string,
                tin: number,
                role_id: number,
                role_name: string) {
    }
}
