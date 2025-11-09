import logoCardPath from '../../../svg/berkas.svg';

export default class StudentCardComponent{

    constructor(title, viewurl){
        this.title = title;
        this.viewurl = viewurl;
        this.img = logoCardPath;
    }

    truncateText(text){
        return text.slice(0,15) + '...';

    }

    render(){

        const gapper = document.createElement('div');
        gapper.classList.add('p-1')

        const container = document.createElement('div');
        container.classList.add(
            'flex','w-50', 'aspect-square','rounded-sm','hover:shadow-md','flex-wrap','shadow-sm','max-w-full', 'p-2', 'border', 'border-gray-200', 'hover:cursor-pointer'
        );

        const cardBody = document.createElement('div');
        cardBody.classList.add(
            'flex','flex-col','gap-2','p-2', 'w-full'
        )

        const thumbnail = document.createElement('img');
        thumbnail.src = this.img;
        thumbnail.classList.add('w-42', 'h-42')
        cardBody.appendChild(thumbnail);

        const actcontainer = document.createElement('div');
        actcontainer.classList.add('flex', 'gap-2', 'justify-center', 'mt-auto');

        const viewButton = document.createElement('a');

        viewButton.href = this.viewurl;
        viewButton.innerText = "dowload";
        viewButton.classList.add('w-full','rounded', 'font-semibold' , 'bg-indigo-600', 'hover:bg-indigo-700', 'text-white', 'shadow-sm', 'hover:shadow-md', 'cursor-pointer', 'p-2', 'text-center');
        actcontainer.appendChild(viewButton)


        const cardTitle = document.createElement('div');
        cardTitle.classList.add(
            'text-center','text-md','font-semibold', 'border', 'border-transparent', 'border-t-indigo-600'
        )
        cardTitle.innerText = this.truncateText(this.title);

        cardBody.appendChild(cardTitle);
        cardBody.appendChild(actcontainer);
        container.appendChild(cardBody)
        gapper.appendChild(container);
        return gapper
    }
}
